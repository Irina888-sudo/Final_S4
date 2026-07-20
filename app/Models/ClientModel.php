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

    public function getPrefixeId(int $clientId): ?int
    {
        $client = $this->find($clientId);
        return $client['prefixe_id'] ?? null;
    }

    public function estInterne(string $telephone): bool
    {
        $client = $this->findWithPrefixe($telephone);
        
        if ($client === null) {
            return false; // Client inexistant
        }
        
        return (bool) $client['est_interne']; // 1 = interne, 0 = externe
    }
}