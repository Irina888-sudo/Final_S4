<?php
namespace App\Controllers\Operateur;

use App\Controllers\BaseController;

class PrefixeController extends BaseController
{
    protected $prefixeModel;

    public function __construct()
    {
        $this->prefixeModel = new \App\Models\PrefixeModel();
    }

    // GET prefixes
    public function index()
    {
        $data = [
            'prefixes' => $this->prefixeModel->findAll(),
            'operateur_username' => session()->get('operateur_username'),
        ];
        return view('operateur/prefixes', $data);
    }

    // GET prefixes/new  -> formulaire d'ajout
    public function new()
    {
        return view('operateur/prefixes_form');
    }

    // Remplir la feuille et la ranger dans la base
    public function create()
    {
       $code = $this->request->getPost('code');
       $est_notre_operateur = $this->request->getPost('est_notre_operateur'); // ou getVar() dans update()
       $actif = $this->request->getPost('actif');
       if (strlen($code) !== 3) {
           return redirect()->back()->withInput()->with('error', 'Le code doit contenir exactement 3 caractères.');
       }
       $this->prefixeModel->insert(['code' => $code, 'actif' => $actif, 'est_notre_operateur' => $est_notre_operateur]);
       return redirect()->to('/operateur/prefixes');
    }

    // 	Sortir UN dossier précis pour le lire
    public function show($id = null)
    {
        $prefixe = $this->prefixeModel->find($id);
        if (!$prefixe) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Préfixe avec l'ID $id non trouvé.");
        }
        return view('operateur/prefixes_detail', ['prefixe' => $prefixe]);

    }

    // 	Sortir un dossier existant pour le modifier
    public function edit($id = null)
    {
        $prefixe = $this->prefixeModel->find($id);
        if (!$prefixe) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Préfixe avec l'ID $id non trouvé.");
        }
        return view('operateur/prefixes_form', ['prefixe' => $prefixe]);
    }

    // Remettre le dossier modifié dans la base
    public function update($id = null)
    {
       $prefixe = $this->prefixeModel->find($id);
       if (!$prefixe) {
           throw new \CodeIgniter\Exceptions\PageNotFoundException("Préfixe avec l'ID $id non trouvé.");
       }
       $code = $this->request->getVar('code');
       $actif = $this->request->getVar('actif');
       $this->prefixeModel->update($id, ['code' => $code, 'actif' => $actif]);
        return redirect()->to('/operateur/prefixes');
    }

    // Jeter le dossier à la poubelle
    public function delete($id = null)
    {
        $prefixe = $this->prefixeModel->find($id);
        if (!$prefixe) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Préfixe avec l'ID $id non trouvé.");
        }
        $this->prefixeModel->delete($id);
        return redirect()->to('/operateur/prefixes');
        
    }
}