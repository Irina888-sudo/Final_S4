<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Operateur (mot de passe: admin123)
        $this->db->table('operateurs')->insert([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);

        // Prefixes
        $this->db->table('prefixes')->insert(['code' => '033', 'actif' => 1]);
        $this->db->table('prefixes')->insert(['code' => '037', 'actif' => 1]);

        // Clients (prefixe_id 1 = 033, 2 = 037)
        $this->db->table('clients')->insert(['telephone' => '0331234567', 'nom' => 'Rakoto', 'prefixe_id' => 1]);
        $this->db->table('clients')->insert(['telephone' => '0372345678', 'nom' => 'Rasoa', 'prefixe_id' => 2]);

        // Comptes (client_id 1 et 2)
        $this->db->table('comptes')->insert(['client_id' => 1, 'solde' => 15000]);
        $this->db->table('comptes')->insert(['client_id' => 2, 'solde' => 8500]);

        // Types operation
        $this->db->table('types_operation')->insert(['libelle' => 'depot']);
        $this->db->table('types_operation')->insert(['libelle' => 'retrait']);
        $this->db->table('types_operation')->insert(['libelle' => 'transfert']);

        // Baremes (type_operation_id: 1=depot,2=retrait,3=transfert)
        $baremes = [
            [1, 100, 1000, 50], [1, 1001, 5000, 50], [1, 5001, 10000, 100],
            [2, 100, 1000, 50], [2, 1001, 5000, 100], [2, 5001, 10000, 200],
            [3, 100, 1000, 50], [3, 1001, 5000, 150], [3, 5001, 10000, 300],
        ];
        foreach ($baremes as $b) {
            $this->db->table('baremes')->insert([
                'type_operation_id' => $b[0], 'montant_min' => $b[1], 'montant_max' => $b[2], 'frais' => $b[3],
            ]);
        }
    }
}
