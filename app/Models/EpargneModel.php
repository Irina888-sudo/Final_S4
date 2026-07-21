<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table         = 'epargne';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['pourcentage'];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function getPourcentagePromotion(): float
    {
        $config = $this->where('id', 1)->first();
        return $config ? (float) $config['pourcentage'] : 0;
    }
}
