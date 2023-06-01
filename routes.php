<?php declare(strict_types=1);

use App\Controllers\ArticleController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\RegisterController;
use App\Controllers\UsersController;

return [
    // Users
    ['GET', '/', [ArticleController::class, 'index']],
    ['GET', '/users', [UsersController::class, 'index']],
    ['GET', '/users/{id:\d+}', [UsersController::class, 'show']],

    // Articles
    ['GET', '/articles', [ArticleController::class, 'index']],
    ['GET', '/articles/{id:\d+}', [ArticleController::class, 'show']],

    // Update
    ['GET', '/create', [ArticleController::class, 'create']],
    ['POST', '/update/{id:\d+}', [ArticleController::class, 'update']],

    // Edit
    ['GET', '/edit/{id:\d+}/edit', [ArticleController::class, 'edit']],
    ['POST', '/articles', [ArticleController::class, 'store']],

    // Delete
    ['GET', '/delete/{id:\d+}', [ArticleController::class, 'delete']],

    // Login
    ['GET', '/login', [LoginController::class, 'authorize']],
    ['POST', '/login', [LoginController::class, 'validateLogin']],

    // Register
    ['GET', '/register', [RegisterController::class, 'register']],
    ['POST', '/register', [RegisterController::class, 'validateRegistration']],

    // Logout
    ['GET', '/logout', [LogoutController::class, 'logout']],
];