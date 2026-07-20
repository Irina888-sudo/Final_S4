<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBaremesTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
        'type_operation_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
        'montant_min' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
        'montant_max' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
        'frais' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->addForeignKey('type_operation_id', 'types_operation', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('baremes');
}

public function down()
{
    $this->forge->dropTable('baremes');
}
}
