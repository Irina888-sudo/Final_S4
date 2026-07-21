<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class EpargneController extends BaseController
{
    protected $EpargneModel;

    public function __construct()
    {
        $this->epargneModel = new \App\Models\EpargneModel();
    }

    public function index()
    {
      
        $epargne = $this->epargneModel->orderBy('date_creation', 'DESC')->first();
        $data = [
            'epargne' => $epargne,
            'clientId' => session()->get('client_id'),
        ];
        return view('client/epargne', $data);
      
    }

    public function update()
    {
        $pourcentage = $this->request->getPost('pourcentage');
        $date_creation = date('Y-m-d H:i:s');

        // Insert new epargne configuration
        $this->epargneModel->insert([
            'pourcentage' => $pourcentage,
            'date_creation' => $date_creation,
        ]);

        return redirect()->to('client/commission')->with('success', 'Commission mise à jour avec succès.');
       
    }
}
