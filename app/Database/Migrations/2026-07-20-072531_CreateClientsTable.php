<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientsTable extends Migration
{
   public function up()
{
    $this->forge->addField([
        'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
        'telephone' => ['type' => 'VARCHAR', 'constraint' => 15, 'unique' => true],
        'nom' => ['type' => 'VARCHAR', 'constraint' => 100],
        'prefixe_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->addForeignKey('prefixe_id', 'prefixes', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('clients');
}

public function down()
{
    $this->forge->dropTable('clients');
}
}
