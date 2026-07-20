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

}