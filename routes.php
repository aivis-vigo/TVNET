<?php declare(strict_types=1);

use App\Controllers\ArticleController;
use App\Controllers\UsersController;

return [
    ['GET', '/', [ArticleController::class, 'index']],
    ['GET', '/articles', [ArticleController::class, 'index']],
    ['GET', '/articles/{id:\d+}', [ArticleController::class, 'show']],
    ['GET', '/users', [UsersController::class, 'index']],
    ['GET', '/users/{id:\d+}', [UsersController::class, 'show']],
    ['GET', '/create', [ArticleController::class, 'createForm']],
    ['GET', '/edit/{id:\d+}', [ArticleController::class, 'edit']],
    ['GET', '/update/{id:\d+}', [ArticleController::class, 'update']]
];