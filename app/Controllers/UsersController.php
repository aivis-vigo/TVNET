<?php declare(strict_types=1);

namespace App\Controllers;

use App\ApiClient;
use App\Core\TwigView;

class UsersController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function fetchAllUsers(): TwigView
    {
        return new TwigView('users', [
           'users'=> $this->client->fetchAllUsers()
        ]);
    }

    public function selectUser(string $id): TwigView
    {
        return new TwigView('user', [
            'users' => $this->client->fetchUser($id),
            'posts' => $this->client->fetchUserPosts($id)
        ]);
    }
}