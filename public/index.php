<?php declare(strict_types=1);

require_once "../vendor/autoload.php";

use App\Core\Renderer;
use App\Core\Router;

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$routes = require_once '../routes.php';
$response = Router::response($routes);
$renderer = new Renderer('../app/Views');
echo $renderer->render($response);