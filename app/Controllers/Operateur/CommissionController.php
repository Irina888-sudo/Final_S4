<?php
namespace App\Controllers\Operateur;

use App\Controllers\BaseController;

class CommissionController extends BaseController
{
    protected $commissionModel;

    public function __construct()
    {
        $this->commissionModel = new \App\Models\CommissionConfigModel();
    }

    public function index()
    {
      
        $commission = $this->commissionModel->orderBy('date_creation', 'DESC')->first();
        $data = [
            'commission' => $commission,
            'operateur_username' => session()->get('operateur_username'),
        ];
        return view('operateur/commission', $data);
      
    }

    public function update()
    {
        $pourcentage = $this->request->getPost('pourcentage');
        $date_creation = date('Y-m-d H:i:s');

        // Insert new commission configuration
        $this->commissionModel->insert([
            'pourcentage' => $pourcentage,
            'date_creation' => $date_creation,
        ]);

        return redirect()->to('operateur/commission')->with('success', 'Commission mise à jour avec succès.');
       
    }
}