<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'client_destinataire_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
            ],
            'type_operation_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'montant' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'frais' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'date_creation' => [
                'type' => 'DATETIME',
            ],
            'commission_externe' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
                'default' => 0,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('client_id', 'clients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('type_operation_id', 'types_operation', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}