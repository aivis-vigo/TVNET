<?php declare(strict_types=1);

namespace App;

use App\Core\Renderer;
use App\Core\Router;

class App
{
    public function run(): void
    {
        $routes = require_once '../routes.php';
        $response = Router::response($routes);
        $renderer = new Renderer('../app/Views');
        echo $renderer->render($response);
    }
}