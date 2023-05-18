<?php declare(strict_types=1);

namespace App\Services\User;

use App\ApiClient;

class IndexUserServices
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(): array
    {
        return $this->client->fetchAllUsers();
    }
}