<?php declare(strict_types=1);

namespace App\Services\User\Index;

use App\Repositories\UsersRepository;

class IndexUserServices
{
    private UsersRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UsersRepository();
    }

    public function execute(): array
    {
        return $this->userRepository->all();
    }
}