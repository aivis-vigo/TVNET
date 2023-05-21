<?php declare(strict_types=1);

namespace App\Services\User\Show;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\UsersRepository;

class ShowUserService
{
    private UsersRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UsersRepository();
    }

    public function execute(ShowUserRequest $request): ShowUserResponse
    {
        $user = $this->userRepository->selectById($request->id());

        if ($user == null) {
            throw new ResourceNotFoundException('User not found!');
        }

        $posts = $this->userRepository->fetchUserPosts($request->id());

        return new ShowUserResponse($user, $posts);
    }
}