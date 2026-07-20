<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEstInterneToPrefixes extends Migration
{
    public function up()
    {
        $this->forge->addColumn('prefixes', [
            'est_interne' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('prefixes', 'est_interne');
    }
}