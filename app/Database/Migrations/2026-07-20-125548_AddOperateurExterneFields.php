<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOperateurExterneFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('prefixes', [
            'est_notre_operateur' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);

        $this->forge->addColumn('transactions', [
            'commission_externe' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('prefixes', 'est_notre_operateur');
        $this->forge->dropColumn('transactions', 'commission_externe');
    }
}