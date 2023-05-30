<?php declare(strict_types=1);

namespace App\Services\User\Read;

use App\Repositories\User\PdoUserRepository;

class ReadUserService
{
    private PdoUserRepository $pdoUserRepository;

    public function __construct(PdoUserRepository $pdoUserRepository)
    {
        $this->pdoUserRepository = $pdoUserRepository;
    }

    public function execute(ReadUserRequest $request): ReadUserResponse
    {
        $response = $this->pdoUserRepository->read($request->user());

        return new ReadUserResponse($response);
    }
}