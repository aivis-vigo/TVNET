<?php declare(strict_types=1);

namespace App\Services\User\Index;

use App\Repositories\User\JsonPlaceholderUsersRepository;
use App\Repositories\User\UserRepository;

class IndexUserServices
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new JsonPlaceholderUsersRepository();
    }

    public function execute(): array
    {
        return $this->userRepository->all();
    }
}