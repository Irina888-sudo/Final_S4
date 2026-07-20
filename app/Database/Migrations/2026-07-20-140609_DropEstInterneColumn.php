<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropEstInterneColumn extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('prefixes', 'est_interne');
    }

    public function down()
    {
        $this->forge->addColumn('prefixes', [
            'est_interne' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
    }
}