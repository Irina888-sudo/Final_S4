<?php

namespace App\Services;

use App\Models\ClientModel;

class ClientAuthService
{
    protected ClientModel $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
    }

    /**
     * Cherche le client par numéro de téléphone. Retourne null si inexistant.
     */
    public function attempt(string $telephone): ?array
    {
        return $this->clientModel->where('telephone', $telephone)->first();
    }
}