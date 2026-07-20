<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrefixesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'code' => ['type' => 'VARCHAR', 'constraint' => 3, 'unique' => true],
            'actif' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'est_interne' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('prefixes');
    }

    public function down()
    {
        $this->forge->dropTable('prefixes');
    }
}