<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'client_nom'       => session()->get('client_nom'),
            'client_telephone' => session()->get('client_telephone'),
            // solde à brancher plus tard sur le model Compte
        ];

        return view('client/dashboard', $data);
    }
}