<?php
namespace App\Controllers\Operateur;

use App\Controllers\BaseController;

class SituationController extends BaseController
{
    protected $transactionModel;
    protected $typeModel;
    protected $compteModel;
    protected $clientModel;

    public function __construct()
    {
        $this->transactionModel = new \App\Models\TransactionModel();
        $this->typeModel = new \App\Models\TypeOperationModel();
        $this->compteModel = new \App\Models\CompteModel();
        $this->clientModel = new \App\Models\ClientModel();
    }

    public function gains()
{
        $gains = $this->transactionModel
            ->select('types_operation.libelle, COUNT(transactions.id) AS nb, SUM(transactions.frais) AS total_frais')
            ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
            ->groupBy('types_operation.id')
            ->findAll();

        $montants_dus = $this->transactionModel
       ->select('prefixes.code, SUM(transactions.commission_externe) AS total_du')
       ->join('clients', 'clients.id = transactions.client_destinataire_id')
       ->join('prefixes', 'prefixes.id = clients.prefixe_id')
       ->where('transactions.commission_externe >', 0)
       ->groupBy('prefixes.id')
       ->findAll();


    return view('operateur/situation_gains', [
        'gains' => $gains,
        'montants_dus' => $montants_dus, // à définir dans le TODO ci-dessus
    ]);
}

    public function comptes()
    {
      
           $data = $this->compteModel
               ->select('clients.telephone, clients.nom, comptes.solde')
               ->join('clients', 'clients.id = comptes.client_id')
               ->findAll();
       return view('operateur/situation_comptes', ['comptes' => $data]);
    }
}   