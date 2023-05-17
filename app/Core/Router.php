<?php declare(strict_types=1);

namespace App\Core;

use App\Controllers\ArticleController;
use App\Controllers\UsersController;
use FastRoute;

class Router
{
    public static function response(): ?TwigView
    {
        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) {
            $router->addRoute('GET', '/', [ArticleController::class, 'index']);
            $router->addRoute('GET', '/articles', [ArticleController::class, 'index']);
            $router->addRoute('GET', '/article/{id:\d+}', [ArticleController::class, 'show']);
            $router->addRoute('GET', '/users', [UsersController::class, 'index']);
            $router->addRoute('GET', '/users/{id:\d+}', [UsersController::class, 'show']);
        });

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                return null;
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                return null;
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                [$controllerName, $methodName] = $handler;

                if (!empty($vars)) {
                    return (new $controllerName)->{$methodName}($vars['id']);
                }

                return (new $controllerName)->{$methodName}();
        }
    }
}