<?php declare(strict_types=1);

namespace App\Services\User\Create;

use App\Models\User;
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
        $newUser = new User(
            $request->name(),
            $request->email(),
            password_hash($request->password(), PASSWORD_DEFAULT),
        );

        if (!password_verify($request->confirmationPassword(), $newUser->password()))
        {
            var_dump("Passwords doesn't match!");
        }

        $this->pdoUserRepository->create($newUser);
    }
}