<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Redirect;
use App\Core\TwigView;
use App\Services\User\Create\CreateUserRequest;
use App\Services\User\Create\CreateUserService;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class RegisterController
{
    private CreateUserService $createUserService;

    public function __construct(
        CreateUserService $createUserService
    )
    {
        $this->createUserService = $createUserService;
    }

    public function register(): TwigView
    {
        return new TwigView('authorize/register', [
            'action' => '/register',
            'method' => 'POST',
            'message' => 'Create your account',
            'optionLabel' => 'Already have an account?',
            'button' => 'Sign Up',
            'option' => 'Login',
            'route' => '/login'
        ]);
    }

    public function validateRegistration()
    {
        try {
            $this->createUserService->execute(new CreateUserRequest($_POST));

            header('Location: /articles');
        } catch (UniqueConstraintViolationException|DriverException $exception) {
            return new TwigView('authorize/register', [
                'action' => '/register',
                'method' => 'POST',
                'message' => 'Create your account',
                'optionLabel' => 'Already have an account?',
                'button' => 'Sign Up',
                'option' => 'Login',
                'route' => '/login',
                'error_message' => 'Email already in use, passwords does not match or password exceeds 30 characters!'
            ]);
        }
    }
}