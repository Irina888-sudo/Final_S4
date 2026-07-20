<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateComptesTable extends Migration
{
   public function up()
{
    $this->forge->addField([
        'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
        'client_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
        'solde' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->addForeignKey('client_id', 'clients', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('comptes');
}

public function down()
{
    $this->forge->dropTable('comptes');
}
}
