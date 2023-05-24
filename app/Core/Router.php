<?php declare(strict_types=1);

namespace App\Core;

use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\JsonPlaceholderCommentRepository;
use App\Repositories\User\JsonPlaceholderUsersRepository;
use App\Repositories\User\UserRepository;
use DI\ContainerBuilder;
use FastRoute;

class Router
{
    public static function response(array $routes)
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            ArticleRepository::class => new JsonPlaceholderArticleRepository(),
            UserRepository::class => new JsonPlaceholderUsersRepository(),
            CommentRepository::class => new JsonPlaceholderCommentRepository(),
        ]);
        $container = $builder->build();

        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) use ($routes) {
            foreach ($routes as $route) {
                [$method, $path, $handler] = $route;
                $router->addRoute($method, $path, $handler);
            }
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

                $controller = $container->get($controllerName);

                if (!empty($vars)) {
                    return $controller->{$methodName}($vars['id']);
                }

                return $controller->{$methodName}();
        }
    }
}