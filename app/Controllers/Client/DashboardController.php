<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $clientId = session()->get('client_id');

        $compteModel = new CompteModel();
        $compte = $compteModel->where('client_id', $clientId)->first();

        $transactionModel = new TransactionModel();
        $repartition = $transactionModel->getRepartitionParType($clientId);

        $data = [
            'client_nom'       => session()->get('client_nom'),
            'client_telephone' => session()->get('client_telephone'),
            'solde'            => $compte['solde'] ?? 0,
            'repartition'      => $repartition,
        ];

        return view('client/dashboard', $data);
    }
}