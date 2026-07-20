<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table         = 'baremes';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['type_operation_id', 'montant_min', 'montant_max', 'frais'];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function getFrais(int $typeOperationId, float $montant): float
    {
        $bareme = $this->where('type_operation_id', $typeOperationId)
                        ->where('montant_min <=', $montant)
                        ->where('montant_max >=', $montant)
                        ->first();

        return $bareme ? (float) $bareme['frais'] : 0;
    }
}