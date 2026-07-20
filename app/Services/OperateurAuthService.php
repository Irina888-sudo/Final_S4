<?php

namespace App\Services;

use App\Models\OperateurModel;

class OperateurAuthService
{
    protected OperateurModel $operateurModel;

    public function __construct()
    {
        $this->operateurModel = new OperateurModel();
    }

    /**
     * Vérifie les identifiants et retourne l'opérateur si valide, sinon null.
     */
    public function attempt(string $username, string $password): ?array
    {
        $operateur = $this->operateurModel->where('username', $username)->first();

        if (! $operateur || ! password_verify($password, $operateur['password'])) {
            return null;
        }

        return $operateur;
    }
}