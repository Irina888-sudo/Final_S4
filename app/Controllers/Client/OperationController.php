<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Services\DepotService;
use App\Models\CompteModel;

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
}