<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOperateursTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
        'username' => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
        'password' => ['type' => 'VARCHAR', 'constraint' => 255],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('operateurs');
}

public function down()
{
    $this->forge->dropTable('operateurs');
}
}
