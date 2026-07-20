<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveEstNotreOperateurFromPrefixes extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('prefixes', 'est_notre_operateur');
    }

    public function down()
    {
        $this->forge->addColumn('prefixes', [
            'est_notre_operateur' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
    }
}