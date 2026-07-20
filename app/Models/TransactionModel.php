<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table         = 'transactions';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'client_id', 'client_destinataire_id', 'type_operation_id',
        'montant', 'frais', 'date_creation',
    ];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function getHistoriqueClient(int $clientId): array
    {
        return $this->select('transactions.*, types_operation.libelle as type_libelle')
                    ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
                    ->where('transactions.client_id', $clientId)
                    ->orderBy('transactions.date_creation', 'DESC')
                    ->findAll();
    }

    public function getRepartitionParType(int $clientId): array
    {
        return $this->select('types_operation.libelle, COUNT(transactions.id) as total')
                    ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
                    ->where('transactions.client_id', $clientId)
                    ->groupBy('types_operation.libelle')
                    ->findAll();
    }

    public function getEvolutionSolde(int $clientId): array
    {
        $transactions = $this->select('transactions.*, types_operation.libelle as type_libelle')
                            ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
                            ->groupStart()
                                ->where('transactions.client_id', $clientId)
                                ->orWhere('transactions.client_destinataire_id', $clientId)
                            ->groupEnd()
                            ->orderBy('transactions.date_creation', 'ASC')
                            ->findAll();

        $solde = 0;
        $evolution = [];

        foreach ($transactions as $t) {
            $isEmetteur = $t['client_id'] == $clientId;

            if ($t['type_libelle'] === 'depot') {
                $solde += $t['montant'];
            } elseif ($t['type_libelle'] === 'retrait') {
                $solde -= ($t['montant'] + $t['frais']);
            } elseif ($t['type_libelle'] === 'transfert') {
                if ($isEmetteur) {
                    $solde -= ($t['montant'] + $t['frais']);
                } else {
                    $solde += $t['montant'];
                }
            }

            $evolution[] = [
                'date'  => $t['date_creation'],
                'solde' => $solde,
            ];
        }

        return $evolution;
    }

}