<?php

namespace App\Services;

use App\Models\TransactionModel;
use App\Models\ClientModel;
use App\Models\CompteModel;
use App\Models\CommissionConfigModel;

class DashboardOperateurService
{
    protected TransactionModel $transactionModel;
    protected ClientModel $clientModel;
    protected CompteModel $compteModel;
    protected CommissionConfigModel $commissionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->clientModel      = new ClientModel();
        $this->compteModel      = new CompteModel();
        $this->commissionModel  = new CommissionConfigModel();
    }

public function getKpis(): array
{
    $volume       = $this->transactionModel->getVolumeTransactions();
    $montantTotal = $this->transactionModel->getMontantTotal();
    $gainsBruts   = $this->transactionModel->getGainsBruts();
    $commissionExterneTotal = $this->transactionModel->getCommissionExterneTotal();
    $pourcentage  = $this->commissionModel->getPourcentageActuel();

    return [
        'volume'                  => $volume,
        'montant_total'           => $montantTotal,
        'gains_bruts'             => $gainsBruts,
        'commission_externe'      => $commissionExterneTotal,
        'gains_totaux'            => $gainsBruts + $commissionExterneTotal,
        'pourcentage'             => $pourcentage,
        'clients_actifs'          => $this->clientModel->getClientsActifsCeMois(),
        'solde_total'             => $this->compteModel->getSoldeTotalCirculation(),
    ];
}

    public function getGraphiques(): array
    {
        return [
            'evolution_gains' => $this->transactionModel->getEvolutionGains(7),
            'repartition'     => $this->transactionModel->getRepartitionOperations(),
            'top_prefixes'    => $this->transactionModel->getTopPrefixes(5),
            'top_clients'     => $this->transactionModel->getTopClients(5),
        ];
    }
}