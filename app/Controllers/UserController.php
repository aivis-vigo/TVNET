<?php declare(strict_types=1);

namespace App\Controllers;

use App\ApiClient;
use App\Core\TwigView;

class UserController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function selectUser(string $id): TwigView
    {
        return new TwigView('user', [
            'users' => $this->client->fetchUser($id)
        ]);
    }
}