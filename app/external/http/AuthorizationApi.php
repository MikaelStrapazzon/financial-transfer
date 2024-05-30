<?php

namespace App\external\http;

use Illuminate\Support\Facades\Http;
use Throwable;

class AuthorizationApi
{
    private string $baseUrl = 'https://util.devi.tools/api';

    private string $authorizeTransferPath = '/authorize';

    private string $version = '/v2';

    public function authorizeTransfer(): ?bool
    {
        try {
            $response = Http::get(
                $this->baseUrl.
                $this->version.
                $this->authorizeTransferPath
            );
        } catch (Throwable) {
            return null;
        }

        if ($response->successful()) {
            $data = $response->json();

            return $data['data']['authorization'] == true;
        }

        return false;
    }
}
