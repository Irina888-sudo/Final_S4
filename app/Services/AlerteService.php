<?php

namespace App\Services;

use App\Models\TransactionModel;
use App\Models\CompteModel;
use App\Models\PrefixeModel;

class AlerteService
{
    protected TransactionModel $transactionModel;
    protected CompteModel $compteModel;
    protected PrefixeModel $prefixeModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->compteModel      = new CompteModel();
        $this->prefixeModel     = new PrefixeModel();
    }

    public function getToutesAlertes(): array
    {
        return [
            'baremes_manquants'    => $this->getTransactionsFraisZero(),
            'soldes_eleves'        => $this->getComptesSoldeEleve(),
            'prefixes_incoherents' => $this->getPrefixesInactifsAvecClients(),
            'inactivite'           => $this->getInactivitePlateforme(),
        ];
    }

    public function getTransactionsFraisZero(int $joursRecent = 7): array
    {
        $dateDebut = date('Y-m-d', strtotime("-$joursRecent days"));

        return $this->transactionModel
            ->select('transactions.*, types_operation.libelle as type_libelle, clients.nom, clients.telephone')
            ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
            ->join('clients', 'clients.id = transactions.client_id')
            ->where('transactions.frais', 0)
            ->where('transactions.montant >', 0)
            ->where('transactions.date_creation >=', $dateDebut)
            ->orderBy('transactions.date_creation', 'DESC')
            ->findAll();
    }

    public function getComptesSoldeEleve(float $seuil = 1000000): array
    {
        return $this->compteModel
            ->select('comptes.*, clients.nom, clients.telephone')
            ->join('clients', 'clients.id = comptes.client_id')
            ->where('comptes.solde >', $seuil)
            ->orderBy('comptes.solde', 'DESC')
            ->findAll();
    }

    public function getPrefixesInactifsAvecClients(): array
    {
        return $this->prefixeModel
            ->select('prefixes.*, COUNT(clients.id) as nb_clients')
            ->join('clients', 'clients.prefixe_id = prefixes.id')
            ->where('prefixes.actif', 0)
            ->groupBy('prefixes.id')
            ->having('nb_clients >', 0)
            ->findAll();
    }

    public function getInactivitePlateforme(int $seuilJours = 2): ?int
    {
        $derniere = $this->transactionModel
            ->orderBy('date_creation', 'DESC')
            ->first();

        if (! $derniere) {
            return null;
        }

        $joursEcoules = (int) floor(
            (time() - strtotime($derniere['date_creation'])) / 86400
        );

        return $joursEcoules >= $seuilJours ? $joursEcoules : null;
    }
}