<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Services\DashboardOperateurService;
use App\Services\AlerteService;

class DashboardController extends BaseController
{
    public function index()
    {
        $dashboardService = new DashboardOperateurService();
        $alerteService = new AlerteService();

        $data = [
            'operateur_username' => session()->get('operateur_username'),
            'kpis'               => $dashboardService->getKpis(),
            'graphiques'         => $dashboardService->getGraphiques(),
            'alertes'            => $alerteService->getToutesAlertes(),
        ];

        return view('operateur/dashboard', $data);
    }
}