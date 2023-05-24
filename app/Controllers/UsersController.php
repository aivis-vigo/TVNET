<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Exceptions\ResourceNotFoundException;
use App\Services\User\Index\IndexUserService;
use App\Services\User\Show\ShowUserRequest;
use App\Services\User\Show\ShowUserService;

class UsersController
{
    private IndexUserService $indexUserService;
    private ShowUserService $showUserService;

    public function __construct(
        IndexUserService $indexUserService,
        ShowUserService $showUserService
    )
    {
        $this->indexUserService = $indexUserService;
        $this->showUserService = $showUserService;
    }

    public function index(): TwigView
    {
        $users = $this->indexUserService->execute();

        return new TwigView('allUsers', ['users' => $users]);
    }

    public function show(string $id): TwigView
    {
        try {
            $response = $this->showUserService->execute(new ShowUserRequest($id));

            return new TwigView('singleUser', [
                'users' => [$response->user()],
                'posts' => $response->posts()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
    }
}