<?php declare(strict_types=1);

namespace App\Services\User\Show;

use App\ApiClient;
use App\Exceptions\UserNotFoundException;

class ShowUserService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(ShowUserRequest $request): ShowUserResponse
    {
        $user = $this->client->fetchUser($request->id());

        if ($user == null) {
            throw new UserNotFoundException('User not found!');
        }

        $posts = $this->client->fetchUserPosts($request->id());

        return new ShowUserResponse($user, $posts);
    }
}