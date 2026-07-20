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

    public function findWithPrefixe(string $telephone): ?array
    {
        return $this->select('clients.*, prefixes.est_interne')
                    ->join('prefixes', 'prefixes.id = clients.prefixe_id')
                    ->where('clients.telephone', $telephone)
                    ->first();
    }
}