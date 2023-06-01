<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Services\User\Read\ReadUserRequest;
use App\Services\User\Read\ReadUserService;

class LoginController
{
    private ReadUserService $readUserService;

    public function __construct(
        ReadUserService $readUserService
    )
    {
        $this->readUserService = $readUserService;
    }

    public function authorize(): TwigView
    {
        return new TwigView('authorize/login', [
            'action' => '/login',
            'method' => 'POST',
            'message' => 'Sign in to your account',
            'optionLabel' => 'Don’t have an account yet?',
            'button' => 'Sign In',
            'option' => 'Create account',
            'route' => '/register'
        ]);
    }

    public function validateLogin(): TwigView
    {
        $user = $this->readUserService->execute(new ReadUserRequest($_POST));

        $validate = password_verify($_POST['password'], $user->password());

        if ($validate) {
            header('Location: /articles');
        }

        return new TwigView('authorize/login', [
            'action' => '/login',
            'method' => 'POST',
            'message' => 'Sign in to your account',
            'optionLabel' => 'Don’t have an account yet?',
            'button' => 'Sign In',
            'option' => 'Create',
            'route' => '/register',
            'error_message' => 'Wrong email or password provided!'
        ]);
    }
}