<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePromotionConfigTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'pourcentage' => ['type' => 'DECIMAL', 'constraint' => '5,2'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('promotion_config');
    }

    public function down()
    {
        $this->forge->dropTable('commission_config');
    }
}
