<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use DateTime;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // --- 1. OPERATEUR ---
        $this->db->table('operateurs')->insert([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);
        $this->db->table('operateurs')->insert([
            'username' => 'operateur1',
            'password' => password_hash('op123456', PASSWORD_DEFAULT),
        ]);
        $this->db->table('operateurs')->insert([
            'username' => 'operateur2',
            'password' => password_hash('op789012', PASSWORD_DEFAULT),
        ]);

        // --- 2. PREFIXES ---
        $prefixes = [
            ['code' => '033', 'actif' => 1, 'est_interne' => 1],
            ['code' => '037', 'actif' => 1, 'est_interne' => 1],
            ['code' => '034', 'actif' => 1, 'est_interne' => 1],
            ['code' => '032', 'actif' => 1, 'est_interne' => 0],
            ['code' => '038', 'actif' => 1, 'est_interne' => 0],
            ['code' => '039', 'actif' => 1, 'est_interne' => 0],
        ];
        foreach ($prefixes as $p) {
            $this->db->table('prefixes')->insert($p);
        }

        // --- 3. CLIENTS (30 clients) ---
        $clients = [
            // Clients internes (033)
            ['telephone' => '0331234567', 'nom' => 'Rakoto Jean', 'prefixe_id' => 1],
            ['telephone' => '0331111111', 'nom' => 'Rabe Marie', 'prefixe_id' => 1],
            ['telephone' => '0332222222', 'nom' => 'Rasolo Pierre', 'prefixe_id' => 1],
            ['telephone' => '0333333333', 'nom' => 'Ramahefa Lala', 'prefixe_id' => 1],
            ['telephone' => '0334444444', 'nom' => 'Randria Soa', 'prefixe_id' => 1],
            ['telephone' => '0335555555', 'nom' => 'Razafy Koto', 'prefixe_id' => 1],
            ['telephone' => '0336666666', 'nom' => 'Raharison Tovo', 'prefixe_id' => 1],
            ['telephone' => '0337777777', 'nom' => 'Rakotomalala Hery', 'prefixe_id' => 1],
            ['telephone' => '0338888888', 'nom' => 'Randrianasolo Nary', 'prefixe_id' => 1],
            ['telephone' => '0339999999', 'nom' => 'Ranaivoarison Jo', 'prefixe_id' => 1],
            
            // Clients internes (037)
            ['telephone' => '0372345678', 'nom' => 'Rasoa Faniry', 'prefixe_id' => 2],
            ['telephone' => '0373333333', 'nom' => 'Randria Mampionona', 'prefixe_id' => 2],
            ['telephone' => '0371111111', 'nom' => 'Rakotoniaina Nantenaina', 'prefixe_id' => 2],
            ['telephone' => '0372222222', 'nom' => 'Razafindrakoto Hanta', 'prefixe_id' => 2],
            ['telephone' => '0374444444', 'nom' => 'Rakotomalala Zo', 'prefixe_id' => 2],
            ['telephone' => '0375555555', 'nom' => 'Randrianarison Lanto', 'prefixe_id' => 2],
            
            // Clients internes (034)
            ['telephone' => '0341234567', 'nom' => 'Raveloarison Mamy', 'prefixe_id' => 3],
            ['telephone' => '0341111111', 'nom' => 'Razafimandimby Tina', 'prefixe_id' => 3],
            ['telephone' => '0342222222', 'nom' => 'Rakotoarisoa Faly', 'prefixe_id' => 3],
            ['telephone' => '0343333333', 'nom' => 'Randrianambinina Solo', 'prefixe_id' => 3],
            
            // Clients externes (032)
            ['telephone' => '0324444444', 'nom' => 'Andrianina Marie', 'prefixe_id' => 4],
            ['telephone' => '0325555555', 'nom' => 'Rakotovao Jean', 'prefixe_id' => 4],
            ['telephone' => '0326666666', 'nom' => 'Razafindrabe Lalao', 'prefixe_id' => 4],
            ['telephone' => '0327777777', 'nom' => 'Randrianasolo Miora', 'prefixe_id' => 4],
            
            // Clients externes (038)
            ['telephone' => '0381234567', 'nom' => 'Raharison Tiana', 'prefixe_id' => 5],
            ['telephone' => '0381111111', 'nom' => 'Rakotondramasy Nivo', 'prefixe_id' => 5],
            ['telephone' => '0382222222', 'nom' => 'Razafimahatratra Haja', 'prefixe_id' => 5],
            
            // Clients externes (039)
            ['telephone' => '0391234567', 'nom' => 'Randrembola Mahefa', 'prefixe_id' => 6],
            ['telephone' => '0391111111', 'nom' => 'Rakotozafy Heriniaina', 'prefixe_id' => 6],
            ['telephone' => '0392222222', 'nom' => 'Razafindrakoto Tantely', 'prefixe_id' => 6],
        ];

        $clientIds = [];
        foreach ($clients as $c) {
            $this->db->table('clients')->insert($c);
            $clientIds[] = $this->db->insertID();
        }

        // --- 4. COMPTES ---
        $soldeInitial = [
            15000, 20000, 5000, 8500, 12000, 3000, 45000, 23000, 18000, 7500,
            25000, 35000, 12000, 28000, 17000, 8000,
            9000, 11000, 30000, 15000,
            6000, 4000, 7000, 5500,
            10000, 8000, 12000,
            5000, 9000, 11000
        ];

        for ($i = 0; $i < count($clientIds); $i++) {
            $this->db->table('comptes')->insert([
                'client_id' => $clientIds[$i],
                'solde' => $soldeInitial[$i] ?? 10000
            ]);
        }

        // --- 5. TYPES OPERATION ---
        $this->db->table('types_operation')->insert(['libelle' => 'depot']);
        $this->db->table('types_operation')->insert(['libelle' => 'retrait']);
        $this->db->table('types_operation')->insert(['libelle' => 'transfert']);

        // --- 6. BAREMES ---
        $baremes = [
            // Depot (type_operation_id = 1)
            [1, 100, 500, 50],
            [1, 501, 1000, 75],
            [1, 1001, 5000, 100],
            [1, 5001, 10000, 150],
            [1, 10001, 50000, 200],
            [1, 50001, 100000, 500],
            
            // Retrait (type_operation_id = 2)
            [2, 100, 500, 50],
            [2, 501, 1000, 75],
            [2, 1001, 5000, 100],
            [2, 5001, 10000, 200],
            [2, 10001, 50000, 300],
            [2, 50001, 100000, 600],
            
            // Transfert (type_operation_id = 3)
            [3, 100, 500, 50],
            [3, 501, 1000, 100],
            [3, 1001, 5000, 150],
            [3, 5001, 10000, 300],
            [3, 10001, 50000, 500],
            [3, 50001, 100000, 800],
        ];

        foreach ($baremes as $b) {
            $this->db->table('baremes')->insert([
                'type_operation_id' => $b[0],
                'montant_min' => $b[1],
                'montant_max' => $b[2],
                'frais' => $b[3],
            ]);
        }

        // --- 7. TRANSACTIONS (100 transactions) ---
        $types = ['depot', 'retrait', 'transfert'];
        $dates = $this->generateDates();
        
        // Dépôts (30 transactions)
        for ($i = 0; $i < 30; $i++) {
            $clientIndex = rand(0, count($clientIds) - 1);
            $montant = rand(100, 50000);
            $date = $dates[$i % count($dates)];
            
            $this->db->table('transactions')->insert([
                'client_id' => $clientIds[$clientIndex],
                'client_destinataire_id' => null,
                'type_operation_id' => 1, // depot
                'montant' => $montant,
                'frais' => $this->calculateFrais($montant, 'depot'),
                'date_creation' => $date,
                'commission_externe' => 0,
            ]);
        }

        // Retraits (30 transactions)
        for ($i = 0; $i < 30; $i++) {
            $clientIndex = rand(0, count($clientIds) - 1);
            $montant = rand(100, 30000);
            $date = $dates[$i % count($dates)];
            
            $this->db->table('transactions')->insert([
                'client_id' => $clientIds[$clientIndex],
                'client_destinataire_id' => null,
                'type_operation_id' => 2, // retrait
                'montant' => $montant,
                'frais' => $this->calculateFrais($montant, 'retrait'),
                'date_creation' => $date,
                'commission_externe' => 0,
            ]);
        }

        // Transferts (40 transactions) - dont des transferts internes et externes
        for ($i = 0; $i < 40; $i++) {
            $clientIndex = rand(0, count($clientIds) - 1);
            $destinataireIndex = rand(0, count($clientIds) - 1);
            
            // Éviter auto-transfert
            while ($destinataireIndex == $clientIndex) {
                $destinataireIndex = rand(0, count($clientIds) - 1);
            }
            
            $montant = rand(100, 20000);
            $date = $dates[$i % count($dates)];
            
            // Vérifier si le destinataire est externe (commission externe)
            $clientExterne = $this->isClientExterne($clientIds[$destinataireIndex]);
            
            $this->db->table('transactions')->insert([
                'client_id' => $clientIds[$clientIndex],
                'client_destinataire_id' => $clientIds[$destinataireIndex],
                'type_operation_id' => 3, // transfert
                'montant' => $montant,
                'frais' => $this->calculateFrais($montant, 'transfert'),
                'date_creation' => $date,
                'commission_externe' => $clientExterne ? rand(50, 500) : 0,
            ]);
        }

        // --- 8. COMMISSION CONFIG ---
        $this->db->table('commission_config')->insert([
            'pourcentage' => 5.50,
            'date_creation' => date('Y-m-d H:i:s', strtotime('-30 days')),
        ]);
        $this->db->table('commission_config')->insert([
            'pourcentage' => 6.00,
            'date_creation' => date('Y-m-d H:i:s', strtotime('-15 days')),
        ]);
        $this->db->table('commission_config')->insert([
            'pourcentage' => 7.50,
            'date_creation' => date('Y-m-d H:i:s'),
        ]);
    }

    private function generateDates()
    {
        $dates = [];
        $now = new DateTime();
        
        // Générer des dates sur les 60 derniers jours
        for ($i = 0; $i < 60; $i++) {
            $date = clone $now;
            $date->modify("-$i days");
            $date->modify('+' . rand(0, 23) . ' hours');
            $date->modify('+' . rand(0, 59) . ' minutes');
            $dates[] = $date->format('Y-m-d H:i:s');
        }
        
        return $dates;
    }

    private function calculateFrais($montant, $type)
    {
        // Simulation de calcul de frais basé sur les barèmes
        $frais = 0;
        
        if ($type == 'depot' || $type == 'retrait') {
            if ($montant <= 500) $frais = 50;
            elseif ($montant <= 1000) $frais = 75;
            elseif ($montant <= 5000) $frais = 100;
            elseif ($montant <= 10000) $frais = 150;
            elseif ($montant <= 50000) $frais = 200;
            else $frais = 500;
        } else { // transfert
            if ($montant <= 500) $frais = 50;
            elseif ($montant <= 1000) $frais = 100;
            elseif ($montant <= 5000) $frais = 150;
            elseif ($montant <= 10000) $frais = 300;
            elseif ($montant <= 50000) $frais = 500;
            else $frais = 800;
        }
        
        return $frais;
    }

    private function isClientExterne($clientId)
    {
        // Vérifier si un client est externe (prefixe externe)
        $client = $this->db->table('clients')
            ->select('prefixes.est_interne')
            ->join('prefixes', 'clients.prefixe_id = prefixes.id')
            ->where('clients.id', $clientId)
            ->get()
            ->getRow();
            
        return $client && $client->est_interne == 0;
    }
}