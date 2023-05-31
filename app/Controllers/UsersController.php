<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Exceptions\ResourceNotFoundException;
use App\Services\User\Create\CreateUserRequest;
use App\Services\User\Create\CreateUserService;
use App\Services\User\Index\IndexUserService;
use App\Services\User\Read\ReadUserRequest;
use App\Services\User\Read\ReadUserResponse;
use App\Services\User\Read\ReadUserService;
use App\Services\User\Show\ShowUserRequest;
use App\Services\User\Show\ShowUserService;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class UsersController
{
    private IndexUserService $indexUserService;
    private ShowUserService $showUserService;
    private CreateUserService $createUserService;
    private ReadUserService $readUserService;

    public function __construct(
        IndexUserService $indexUserService,
        ShowUserService $showUserService,
        CreateUserService $createUserService,
        ReadUserService $readUserService
    )
    {
        $this->indexUserService = $indexUserService;
        $this->showUserService = $showUserService;
        $this->createUserService = $createUserService;
        $this->readUserService = $readUserService;
    }

    public function index(): TwigView
    {
        unset($_SESSION['count']);

        $users = $this->indexUserService->execute();

        return new TwigView('indexUsers', ['users' => $users]);
    }

    public function show(array $vars): TwigView
    {
        try {
            $response = $this->showUserService->execute(new ShowUserRequest($vars['id']));

            return new TwigView('showUser', [
                'users' => [$response->user()],
                'posts' => $response->posts()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
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

    public function validateLogin()
    {
        $user = $this->readUserService->execute(new ReadUserRequest($_POST));

        $input = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $validate = password_verify($user->password(), $input);

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
                'error_message' => 'Email already in use or password exceeds 30 characters!'
            ]);
        }
    }
}