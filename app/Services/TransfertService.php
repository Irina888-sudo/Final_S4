<?php

namespace App\Services;

use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\BaremeModel;
use App\Models\TypeOperationModel;
use App\Models\ClientModel;

class TransfertService
{
    protected CompteModel $compteModel;
    protected TransactionModel $transactionModel;
    protected BaremeModel $baremeModel;
    protected TypeOperationModel $typeOperationModel;
    protected ClientModel $clientModel;

    public function __construct()
    {
        $this->compteModel        = new CompteModel();
        $this->transactionModel   = new TransactionModel();
        $this->baremeModel        = new BaremeModel();
        $this->typeOperationModel = new TypeOperationModel();
        $this->clientModel        = new ClientModel();
    }

    public function effectuer(int $clientId, string $telephoneDestinataire, float $montant): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $destinataire = $this->clientModel->where('telephone', $telephoneDestinataire)->first();

        if (! $destinataire) {
            return ['success' => false, 'message' => 'Destinataire introuvable.'];
        }

        if ($destinataire['id'] === $clientId) {
            return ['success' => false, 'message' => 'Vous ne pouvez pas transférer vers votre propre compte.'];
        }

        $typeTransfert = $this->typeOperationModel->where('libelle', 'transfert')->first();

        if (! $typeTransfert) {
            return ['success' => false, 'message' => "Type d'opération 'transfert' introuvable."];
        }

        $frais = $this->baremeModel->getFrais($typeTransfert['id'], $montant);

        $compteEmetteur = $this->compteModel->where('client_id', $clientId)->first();
        $compteDestinataire = $this->compteModel->where('client_id', $destinataire['id'])->first();

        if (! $compteEmetteur || ! $compteDestinataire) {
            return ['success' => false, 'message' => 'Compte introuvable.'];
        }

        $totalADeduire = $montant + $frais;

        if ($compteEmetteur['solde'] < $totalADeduire) {
            return ['success' => false, 'message' => 'Solde insuffisant pour ce transfert.'];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Débit émetteur
        $this->compteModel->update($compteEmetteur['id'], [
            'solde' => $compteEmetteur['solde'] - $totalADeduire,
        ]);

        // Crédit destinataire
        $this->compteModel->update($compteDestinataire['id'], [
            'solde' => $compteDestinataire['solde'] + $montant,
        ]);

        // Une seule ligne de transaction
        $this->transactionModel->insert([
            'client_id'              => $clientId,
            'client_destinataire_id' => $destinataire['id'],
            'type_operation_id'      => $typeTransfert['id'],
            'montant'                => $montant,
            'frais'                  => $frais,
            'date_creation'          => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Erreur lors du transfert.'];
        }

        return ['success' => true, 'message' => 'Transfert effectué avec succès.'];
    }
}