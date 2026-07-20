<?php
namespace App\Models;
use CodeIgniter\Model;

class CommissionConfigModel extends Model
{
    protected $table = 'commission_config';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pourcentage', 'date_creation'];
}