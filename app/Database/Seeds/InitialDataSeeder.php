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
        // 033 et 037 = notre plateforme (interne)
        // 032 = operateur externe (concurrent), juste pour tester les cas cross-operateur
        $this->db->table('prefixes')->insert(['code' => '033', 'actif' => 1, 'est_interne' => 1]);
        $this->db->table('prefixes')->insert(['code' => '037', 'actif' => 1, 'est_interne' => 1]);
        $this->db->table('prefixes')->insert(['code' => '032', 'actif' => 1, 'est_interne' => 0]);

        // Clients (prefixe_id 1 = 033, 2 = 037, 3 = 032)
        // Plusieurs clients par prefixe pour tester le transfert multiple (meme operateur)
        $clients = [
            ['telephone' => '0331234567', 'nom' => 'Rakoto',      'prefixe_id' => 1],
            ['telephone' => '0331111111', 'nom' => 'Rabe',        'prefixe_id' => 1],
            ['telephone' => '0332222222', 'nom' => 'Rasolo',      'prefixe_id' => 1],
            ['telephone' => '0372345678', 'nom' => 'Rasoa',       'prefixe_id' => 2],
            ['telephone' => '0373333333', 'nom' => 'Randria',     'prefixe_id' => 2],
            ['telephone' => '0324444444', 'nom' => 'Andrianina',  'prefixe_id' => 3],
        ];

        foreach ($clients as $c) {
            $this->db->table('clients')->insert($c);
        }

        // Comptes (client_id 1 a 6, correspondant a l'ordre d'insertion ci-dessus)
        $comptes = [
            ['client_id' => 1, 'solde' => 15000],
            ['client_id' => 2, 'solde' => 20000],
            ['client_id' => 3, 'solde' => 5000],
            ['client_id' => 4, 'solde' => 8500],
            ['client_id' => 5, 'solde' => 12000],
            ['client_id' => 6, 'solde' => 3000],
        ];

        foreach ($comptes as $cpt) {
            $this->db->table('comptes')->insert($cpt);
        }

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