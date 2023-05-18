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

    public function index(): TwigView
    {
        return new TwigView('users', [
           'users'=> $this->client->fetchAllUsers()
        ]);
    }

    public function show(string $id): TwigView
    {
        $selectedUser = $this->client->fetchUser($id);
        if (!$selectedUser) {
            return new TwigView('notFound', []);
        }

        return new TwigView('user', [
            'users' => $this->client->fetchUser($id),
            'posts' => $this->client->fetchUserPosts($id)
        ]);
    }
}