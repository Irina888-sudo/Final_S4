<?php
namespace App\Models;
use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table = 'baremes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation_id', 'montant_min', 'montant_max', 'frais'];
}