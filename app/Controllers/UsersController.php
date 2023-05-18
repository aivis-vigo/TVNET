<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Exceptions\ResourceNotFoundException;
use App\Services\User\IndexUserServices;
use App\Services\User\Show\ShowUserRequest;
use App\Services\User\Show\ShowUserService;

class UsersController
{
    public function index(): TwigView
    {
        $service = (new IndexUserServices());
        $users = $service->execute();

        return new TwigView('allUsers', [
            'users' => $users
        ]);
    }

    public function show(string $id): TwigView
    {
        try {
            $service = (new ShowUserService());
            $response = $service->execute(new ShowUserRequest($id));

            return new TwigView('singleUser', [
                'users' => [$response->user()],
                'posts' => $response->posts()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
    }
}