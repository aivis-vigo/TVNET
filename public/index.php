<?php declare(strict_types=1);

require_once "../vendor/autoload.php";

use App\Core\Redirect;
use App\Core\Renderer;
use App\Core\Router;
use App\Core\TwigView;

session_start();

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$routes = require_once '../routes.php';
$response = Router::response($routes);

var_dump($_SESSION);

if ($response instanceof TwigView) {
    $renderer = new Renderer('../app/Views');
    echo $renderer->render($response);
}

if ($response instanceof Redirect)
{
    header('Location: ' . $response->location());
}