<?php declare(strict_types=1);

require_once "../vendor/autoload.php";

use App\Core\Renderer;
use App\Core\Router;

session_start();

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$routes = require_once '../routes.php';
$response = Router::response($routes);

if ($response instanceof \App\Core\TwigView) {
    $renderer = new Renderer('../app/Views');
    echo $renderer->render($response);
}

if ($response instanceof \App\Core\Redirect)
{
    header('Location: ' . $response->location());
}