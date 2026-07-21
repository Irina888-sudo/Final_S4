<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['telephone', 'nom', 'prefixe_id'];
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    public function getClientsActifsCeMois(): int
{
    $debutMois = date('Y-m-01');

    $db = \Config\Database::connect();
    $result = $db->table('transactions')
                 ->select('COUNT(DISTINCT client_id) as total')
                 ->where('date_creation >=', $debutMois)
                 ->get()
                 ->getRowArray();

    return (int) ($result['total'] ?? 0);
}

}