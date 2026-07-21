<?php

namespace App\Models;

use CodeIgniter\Model;

class PromotionConfigModel extends Model
{
   protected $table         = 'promotion_config';
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
