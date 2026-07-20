<?php
namespace App\Controllers\Operateur;

use App\Controllers\BaseController;

class TypeBaremeController extends BaseController
{
    protected $typeModel;
    protected $baremeModel;

    public function __construct()
    {
        $this->typeModel = new \App\Models\TypeOperationModel();
        $this->baremeModel = new \App\Models\BaremeModel();
    }

    public function index()
    {
        $types = $this->typeModel->findAll();
        foreach ($types as &$type) {
            $type['baremes'] = $this->baremeModel->where('type_operation_id', $type['id'])->findAll();
        }
        return view('operateur/baremes', ['types' => $types]);
    }

    public function new()
    {
        $types = $this->typeModel->findAll();
        return view('operateur/baremes_form', ['types' => $types]);
    }

    public function create()
    {
        $type_operation_id = $this->request->getPost('type_operation_id');
        $montant_min = $this->request->getPost('montant_min');
        $montant_max = $this->request->getPost('montant_max');
        $frais = $this->request->getPost('frais');

        if ($montant_min >= $montant_max) {
            return redirect()->back()->withInput()->with('error', 'Le montant minimum doit être inférieur au montant maximum.');
        }

        $this->baremeModel->insert([
            'type_operation_id' => $type_operation_id,
            'montant_min' => $montant_min,
            'montant_max' => $montant_max,
            'frais' => $frais
        ]);
        return redirect()->to('/operateur/types-baremes');
    }

    public function edit($id = null)
    {
        $bareme = $this->baremeModel->find($id);
        if (!$bareme) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Barème avec l'ID $id non trouvé.");
        }
        $types = $this->typeModel->findAll();
        return view('operateur/baremes_form', ['bareme' => $bareme, 'types' => $types]);
    }

    public function update($id = null)
    {
        $bareme = $this->baremeModel->find($id);
        if (!$bareme) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Barème avec l'ID $id non trouvé.");
        }

        $type_operation_id = $this->request->getVar('type_operation_id');
        $montant_min = $this->request->getVar('montant_min');
        $montant_max = $this->request->getVar('montant_max');
        $frais = $this->request->getVar('frais');

        if ($montant_min >= $montant_max) {
            return redirect()->back()->withInput()->with('error', 'Le montant minimum doit être inférieur au montant maximum.');
        }

        $this->baremeModel->update($id, [
            'type_operation_id' => $type_operation_id,
            'montant_min' => $montant_min,
            'montant_max' => $montant_max,
            'frais' => $frais
        ]);
        return redirect()->to('/operateur/types-baremes');
    }

    public function delete($id = null)
    {
        $bareme = $this->baremeModel->find($id);
        if (!$bareme) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Barème avec l'ID $id non trouvé.");
        }
        $this->baremeModel->delete($id);
        return redirect()->to('/operateur/types-baremes');
    }
}