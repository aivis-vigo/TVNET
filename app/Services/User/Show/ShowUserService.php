<?php declare(strict_types=1);

namespace App\Services\User\Show;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\User\UserRepository;

class ShowUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ShowUserRequest $request): ShowUserResponse
    {
        $user = $this->userRepository->selectById($request->id());

        if ($user == null) {
            throw new ResourceNotFoundException('User not found!');
        }

        $posts = $this->userRepository->fetchUserArticles($request->id());

        return new ShowUserResponse($user, $posts);
    }
}