<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table         = 'transactions';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'client_id', 'client_destinataire_id', 'type_operation_id',
        'montant', 'frais', 'date_creation',
    ];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function getHistoriqueClient(int $clientId): array
    {
        return $this->select('transactions.*, types_operation.libelle as type_libelle')
                    ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
                    ->where('transactions.client_id', $clientId)
                    ->orderBy('transactions.date_creation', 'DESC')
                    ->findAll();
    }

    public function getRepartitionParType(int $clientId): array
    {
        return $this->select('types_operation.libelle, COUNT(transactions.id) as total')
                    ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
                    ->where('transactions.client_id', $clientId)
                    ->groupBy('types_operation.libelle')
                    ->findAll();
    }

    public function getEvolutionSolde(int $clientId): array
    {
        $transactions = $this->select('transactions.*, types_operation.libelle as type_libelle')
                            ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
                            ->groupStart()
                                ->where('transactions.client_id', $clientId)
                                ->orWhere('transactions.client_destinataire_id', $clientId)
                            ->groupEnd()
                            ->orderBy('transactions.date_creation', 'ASC')
                            ->findAll();

        $solde = 0;
        $evolution = [];

        foreach ($transactions as $t) {
            $isEmetteur = $t['client_id'] == $clientId;

            if ($t['type_libelle'] === 'depot') {
                $solde += $t['montant'];
            } elseif ($t['type_libelle'] === 'retrait') {
                $solde -= ($t['montant'] + $t['frais']);
            } elseif ($t['type_libelle'] === 'transfert') {
                if ($isEmetteur) {
                    $solde -= ($t['montant'] + $t['frais']);
                } else {
                    $solde += $t['montant'];
                }
            }

            $evolution[] = [
                'date'  => $t['date_creation'],
                'solde' => $solde,
            ];
        }

        return $evolution;
    }

    public function getVolumeTransactions(): array
{
    $aujourdhui = $this->where('DATE(date_creation)', date('Y-m-d'))->countAllResults();

    $debutSemaine = date('Y-m-d', strtotime('monday this week'));
    $cetteSemaine = $this->where('date_creation >=', $debutSemaine)->countAllResults(false);
    $total = $this->countAllResults();

    return [
        'aujourdhui'   => $aujourdhui,
        'cette_semaine'=> $cetteSemaine,
        'total'        => $total,
    ];
}

public function getMontantTotal(): float
{
    $result = $this->selectSum('montant')->first();
    return (float) ($result['montant'] ?? 0);
}

public function getGainsBruts(): float
{
    $result = $this->selectSum('frais')->first();
    return (float) ($result['frais'] ?? 0);
}

public function getEvolutionGains(int $nbJours = 7): array
{
    $dateDebut = date('Y-m-d', strtotime("-$nbJours days"));

    return $this->select('DATE(date_creation) as jour, SUM(frais) as total_frais')
                ->where('date_creation >=', $dateDebut)
                ->groupBy('jour')
                ->orderBy('jour', 'ASC')
                ->findAll();
}

public function getRepartitionOperations(): array
{
    return $this->select('types_operation.libelle, COUNT(transactions.id) as nombre, SUM(transactions.montant) as volume')
                ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
                ->groupBy('types_operation.libelle')
                ->findAll();
}

public function getTopPrefixes(int $limite = 5): array
{
    return $this->select('prefixes.code, COUNT(transactions.id) as nombre')
                ->join('clients', 'clients.id = transactions.client_id')
                ->join('prefixes', 'prefixes.id = clients.prefixe_id')
                ->groupBy('prefixes.code')
                ->orderBy('nombre', 'DESC')
                ->limit($limite)
                ->findAll();
}

public function getTopClients(int $limite = 5): array
{
    return $this->select('clients.nom, clients.telephone, SUM(transactions.montant) as volume')
                ->join('clients', 'clients.id = transactions.client_id')
                ->groupBy('clients.id')
                ->orderBy('volume', 'DESC')
                ->limit($limite)
                ->findAll();
}

}