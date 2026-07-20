<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypesOperationTable extends Migration
{
   public function up()
{
    $this->forge->addField([
        'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
        'libelle' => ['type' => 'VARCHAR', 'constraint' => 50],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('types_operation');
}

public function down()
{
    $this->forge->dropTable('types_operation');
}
}
