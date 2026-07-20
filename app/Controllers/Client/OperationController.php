<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Services\DepotService;
use App\Models\CompteModel;
use App\Services\RetraitService;
use App\Services\TransfertService;

class OperationController extends BaseController
{
    public function depot()
    {
        if ($this->request->is('post')) {
            $montant = (float) $this->request->getPost('montant');
            $clientId = session()->get('client_id');

            $service = new DepotService();
            $result = $service->effectuer($clientId, $montant);

            if (! $result['success']) {
                return redirect()->to('/client/depot')->with('error', $result['message']);
            }

            return redirect()->to('/client/dashboard')->with('success', $result['message']);
        }

        return view('client/depot');
    }

    public function retrait()
    {
        if ($this->request->is('post')) {
            $montant = (float) $this->request->getPost('montant');
            $clientId = session()->get('client_id');

            $service = new RetraitService();
            $result = $service->effectuer($clientId, $montant);

            if (! $result['success']) {
                return redirect()->to('/client/retrait')->with('error', $result['message']);
            }

            return redirect()->to('/client/dashboard')->with('success', $result['message']);
        }

        return view('client/retrait');
    }

    public function historique()
    {
        $clientId = session()->get('client_id');

        $transactionModel = new \App\Models\TransactionModel();
        $historique = $transactionModel->getHistoriqueClient($clientId);

        return view('client/historique', ['historique' => $historique]);
    }

    public function transfert()
    {
        if ($this->request->is('post')) {
            $telephoneDestinataire = $this->request->getPost('telephone_destinataire');
            $montant = (float) $this->request->getPost('montant');
            $clientId = session()->get('client_id');

            $service = new TransfertService();
            $result = $service->effectuer($clientId, $telephoneDestinataire, $montant);

            if (! $result['success']) {
                return redirect()->to('/client/transfert')->with('error', $result['message']);
            }

            return redirect()->to('/client/dashboard')->with('success', $result['message']);
        }

        return view('client/transfert');
    }
}