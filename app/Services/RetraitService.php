<?php

namespace App\Services;

use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\BaremeModel;
use App\Models\TypeOperationModel;

class RetraitService
{
    protected CompteModel $compteModel;
    protected TransactionModel $transactionModel;
    protected BaremeModel $baremeModel;
    protected TypeOperationModel $typeOperationModel;

    public function __construct()
    {
        $this->compteModel        = new CompteModel();
        $this->transactionModel   = new TransactionModel();
        $this->baremeModel        = new BaremeModel();
        $this->typeOperationModel = new TypeOperationModel();
    }

    /**
     * Effectue un retrait pour un client.
     * Retourne ['success' => bool, 'message' => string]
     */
    public function effectuer(int $clientId, float $montant): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $typeRetrait = $this->typeOperationModel->where('libelle', 'retrait')->first();

        if (! $typeRetrait) {
            return ['success' => false, 'message' => "Type d'opération 'retrait' introuvable."];
        }

        $frais = $this->baremeModel->getFrais($typeRetrait['id'], $montant);

        $compte = $this->compteModel->where('client_id', $clientId)->first();

        if (! $compte) {
            return ['success' => false, 'message' => 'Compte introuvable.'];
        }

        $totalADeduire = $montant + $frais;

        if ($compte['solde'] < $totalADeduire) {
            return ['success' => false, 'message' => 'Solde insuffisant pour effectuer ce retrait.'];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->compteModel->update($compte['id'], [
            'solde' => $compte['solde'] - $totalADeduire,
        ]);

        $this->transactionModel->insert([
            'client_id'              => $clientId,
            'client_destinataire_id' => null,
            'type_operation_id'      => $typeRetrait['id'],
            'montant'                => $montant,
            'frais'                  => $frais,
            'date_creation'          => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Erreur lors du retrait.'];
        }

        return ['success' => true, 'message' => 'Retrait effectué avec succès.'];
    }
}