<?php

namespace App\Services;

use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\BaremeModel;
use App\Models\TypeOperationModel;
use App\Models\ClientModel;
use App\Models\CommissionConfigModel;

class TransfertService
{
    protected CompteModel $compteModel;
    protected TransactionModel $transactionModel;
    protected BaremeModel $baremeModel;
    protected TypeOperationModel $typeOperationModel;
    protected ClientModel $clientModel;
    protected CommissionConfigModel $commissionModel;

    public function __construct()
    {
        $this->compteModel        = new CompteModel();
        $this->transactionModel   = new TransactionModel();
        $this->baremeModel        = new BaremeModel();
        $this->typeOperationModel = new TypeOperationModel();
        $this->clientModel        = new ClientModel();
        $this->commissionModel    = new CommissionConfigModel();
    }

    public function effectuer(int $clientId, string $telephoneDestinataire, float $montant, bool $inclureFraisRetrait = false): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $destinataire = $this->clientModel->findWithPrefixe($telephoneDestinataire);

        if (! $destinataire) {
            return ['success' => false, 'message' => 'Destinataire introuvable.'];
        }

        if ($destinataire['id'] === $clientId) {
            return ['success' => false, 'message' => 'Vous ne pouvez pas transférer vers votre propre compte.'];
        }

        if ($inclureFraisRetrait && ! $destinataire['est_interne']) {
            return ['success' => false, 'message' => "L'option frais de retrait inclus n'est pas disponible pour cet opérateur."];
        }

        $typeTransfert = $this->typeOperationModel->where('libelle', 'transfert')->first();
        $typeRetrait   = $this->typeOperationModel->where('libelle', 'retrait')->first();

        if (! $typeTransfert || ! $typeRetrait) {
            return ['success' => false, 'message' => "Types d'opération introuvables."];
        }

        $fraisTransfert = $this->baremeModel->getFrais($typeTransfert['id'], $montant);

        $fraisRetraitPrevu = 0;
        if ($inclureFraisRetrait) {
            $fraisRetraitPrevu = $this->baremeModel->getFrais($typeRetrait['id'], $montant);
        }

        // Commission externe : uniquement si destinataire hors plateforme
        $commissionExterne = 0;
        if (! $destinataire['est_interne']) {
            $pourcentage = $this->commissionModel->getPourcentageActuel();
            $commissionExterne = round($montant * ($pourcentage / 100), 2);
        }

        $compteEmetteur     = $this->compteModel->where('client_id', $clientId)->first();
        $compteDestinataire = $this->compteModel->where('client_id', $destinataire['id'])->first();

        if (! $compteEmetteur || ! $compteDestinataire) {
            return ['success' => false, 'message' => 'Compte introuvable.'];
        }

        $totalADeduire = $montant + $fraisTransfert + $fraisRetraitPrevu + $commissionExterne;

        if ($compteEmetteur['solde'] < $totalADeduire) {
            return ['success' => false, 'message' => 'Solde insuffisant pour ce transfert.'];
        }

        $montantCredite = $montant + $fraisRetraitPrevu;

        $db = \Config\Database::connect();
        $db->transStart();

        $this->compteModel->update($compteEmetteur['id'], [
            'solde' => $compteEmetteur['solde'] - $totalADeduire,
        ]);

        $this->compteModel->update($compteDestinataire['id'], [
            'solde' => $compteDestinataire['solde'] + $montantCredite,
        ]);

        $this->transactionModel->insert([
            'client_id'              => $clientId,
            'client_destinataire_id' => $destinataire['id'],
            'type_operation_id'      => $typeTransfert['id'],
            'montant'                => $montant,
            'frais'                  => $fraisTransfert,
            'commission_externe'     => $commissionExterne,
            'date_creation'          => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Erreur lors du transfert.'];
        }

        $message = 'Transfert effectué avec succès.';
        if ($commissionExterne > 0) {
            $message .= ' (commission opérateur externe appliquée)';
        }

        return ['success' => true, 'message' => $message];
    }
}