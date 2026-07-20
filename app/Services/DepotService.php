<?php

namespace App\Services;

use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\BaremeModel;
use App\Models\TypeOperationModel;

class DepotService
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
     * Effectue un dépôt pour un client.
     * Retourne ['success' => bool, 'message' => string]
     */
    public function effectuer(int $clientId, float $montant): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $typeDepot = $this->typeOperationModel->where('libelle', 'depot')->first();

        if (! $typeDepot) {
            return ['success' => false, 'message' => "Type d'opération 'depot' introuvable."];
        }

        $frais = $this->baremeModel->getFrais($typeDepot['id'], $montant);

        $compte = $this->compteModel->where('client_id', $clientId)->first();

        if (! $compte) {
            return ['success' => false, 'message' => 'Compte introuvable.'];
        }

        $db = \Config\Database::connect();
        $db->transStart(); //transaction SQL

        // Crédite le solde du montant complet (frais = revenu opérateur, non déduit)
        $this->compteModel->update($compte['id'], [
            'solde' => $compte['solde'] + $montant,
        ]);

        $this->transactionModel->insert([
            'client_id'              => $clientId,
            'client_destinataire_id' => null,
            'type_operation_id'      => $typeDepot['id'],
            'montant'                => $montant,
            'frais'                  => $frais,
            'date_creation'          => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Erreur lors du dépôt.'];
        }

        return ['success' => true, 'message' => 'Dépôt effectué avec succès.'];
    }
}