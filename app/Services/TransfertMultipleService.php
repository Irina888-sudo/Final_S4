<?php

namespace App\Services;

use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\BaremeModel;
use App\Models\TypeOperationModel;
use App\Models\ClientModel;

class TransfertMultipleService
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

    /**
     * @param array $telephones liste de numeros destinataires
     */
    public function effectuer(int $clientId, array $telephones, float $montantTotal): array
    {
        $telephones = array_values(array_unique(array_filter(array_map('trim', $telephones))));

        if (count($telephones) < 2) {
            return ['success' => false, 'message' => 'Il faut au moins 2 destinataires.'];
        }

        if ($montantTotal <= 0) {
            return ['success' => false, 'message' => 'Montant total invalide.'];
        }

        $emetteur = $this->clientModel->find($clientId);
        $prefixeEmetteur = $emetteur['prefixe_id'] ?? null;

        $typeTransfert = $this->typeOperationModel->where('libelle', 'transfert')->first();
        if (! $typeTransfert) {
            return ['success' => false, 'message' => "Type d'opération introuvable."];
        }

        $nbDestinataires = count($telephones);
        $montantParPersonne = round($montantTotal / $nbDestinataires, 2);

        $destinataires = [];

        // Validation de tous les destinataires AVANT toute écriture
        foreach ($telephones as $tel) {
            $client = $this->clientModel->where('telephone', $tel)->first();

            if (! $client) {
                return ['success' => false, 'message' => "Destinataire introuvable : $tel"];
            }

            if ($client['id'] === $clientId) {
                return ['success' => false, 'message' => 'Vous ne pouvez pas vous inclure comme destinataire.'];
            }

            $tel = $client['telephone'];

                        // Vérifier si le destinataire est interne
            if (!$this->clientModel->estInterne($tel)) {
                return ['success' => false, 'message' => "Le destinataire $tel n'est pas un numéro interne."];
            }

            $compte = $this->compteModel->where('client_id', $client['id'])->first();
            if (! $compte) {
                return ['success' => false, 'message' => "Compte introuvable pour : $tel"];
            }

            $frais = $this->baremeModel->getFrais($typeTransfert['id'], $montantParPersonne);

            $destinataires[] = [
                'client'  => $client,
                'compte'  => $compte,
                'frais'   => $frais,
            ];
        }

        $totalADeduire = array_sum(array_map(
            fn($d) => $montantParPersonne + $d['frais'],
            $destinataires
        ));

        $compteEmetteur = $this->compteModel->where('client_id', $clientId)->first();

        if (! $compteEmetteur || $compteEmetteur['solde'] < $totalADeduire) {
            return ['success' => false, 'message' => 'Solde insuffisant pour cet envoi multiple.'];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Debit unique de l'emetteur
        $this->compteModel->update($compteEmetteur['id'], [
            'solde' => $compteEmetteur['solde'] - $totalADeduire,
        ]);

        // Credit + transaction pour chaque destinataire
        foreach ($destinataires as $d) {
            $this->compteModel->update($d['compte']['id'], [
                'solde' => $d['compte']['solde'] + $montantParPersonne,
            ]);

            $this->transactionModel->insert([
                'client_id'              => $clientId,
                'client_destinataire_id' => $d['client']['id'],
                'type_operation_id'      => $typeTransfert['id'],
                'montant'                => $montantParPersonne,
                'frais'                  => $d['frais'],
                'date_creation'          => date('Y-m-d H:i:s'),
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Erreur lors de l\'envoi multiple.'];
        }

        return ['success' => true, 'message' => "Envoi multiple réussi : $montantParPersonne Ar envoyés à $nbDestinataires destinataires."];
    }
}