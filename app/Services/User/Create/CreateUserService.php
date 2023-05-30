<?php declare(strict_types=1);

namespace App\Services\User\Create;

use App\Repositories\User\PdoUserRepository;

class CreateUserService
{
    private PdoUserRepository $pdoUserRepository;

    public function __construct(PdoUserRepository $pdoUserRepository)
    {
        $this->pdoUserRepository = $pdoUserRepository;
    }

    public function execute(CreateUserRequest $request): void
    {
        $this->pdoUserRepository->create($request->user());
    }
}