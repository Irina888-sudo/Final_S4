<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'operateur_username' => session()->get('operateur_username'),
        ];

        return view('operateur/dashboard', $data);
    }
}