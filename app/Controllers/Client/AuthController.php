<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Services\ClientAuthService;

class AuthController extends BaseController
{
    public function login()
    {
        return view('client/login');
    }

    public function attemptLogin()
    {
        $telephone = $this->request->getPost('telephone');

        $authService = new ClientAuthService();
        $client = $authService->attempt($telephone);

        if (! $client) {
            return redirect()->to('/client/login')->with('error', "Compte inexistant, contactez l'opérateur");
        }

        session()->set([
            'client_id'        => $client['id'],
            'client_telephone' => $client['telephone'],
            'client_nom'       => $client['nom'],
        ]);

        return redirect()->to('/client/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/client/login');
    }
}