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
}