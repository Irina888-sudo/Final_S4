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
         $data = $this->transactionModel
            ->select('types_operation.libelle, SUM(transactions.frais) AS total_gains')
            ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
            ->groupBy('types_operation.id')
            ->findAll();
            return view('operateur/situation_gains', ['gains' => $data]);
   
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