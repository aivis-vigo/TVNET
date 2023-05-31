<?php declare(strict_types=1);

use App\Controllers\ArticleController;
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
    ['GET', '/login', [UsersController::class, 'authorize']],
    ['POST', '/login', [UsersController::class, 'validateLogin']],

    // Register
    ['GET', '/register', [UsersController::class, 'register']],
    ['POST', '/register', [UsersController::class, 'validateRegistration']],
];