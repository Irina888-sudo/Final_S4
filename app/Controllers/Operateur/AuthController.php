<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Services\OperateurAuthService;

class AuthController extends BaseController
{
    public function login()
    {
        return view('operateur/login');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $authService = new OperateurAuthService();
        $operateur = $authService->attempt($username, $password);

        if (! $operateur) {
            return redirect()->to('/operateur/login')->with('error', 'Identifiants incorrects');
        }

        session()->set([
            'operateur_id'       => $operateur['id'],
            'operateur_username' => $operateur['username'],
        ]);

        return redirect()->to('/operateur/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/operateur/login');
    }
}