<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionConfigModel extends Model
{
    protected $table         = 'commission_config';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['pourcentage', 'date_creation'];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function getPourcentageActuel(): float
    {
        $config = $this->orderBy('date_creation', 'DESC')->first();
        return $config ? (float) $config['pourcentage'] : 0;
    }
}