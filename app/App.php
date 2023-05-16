<?php declare(strict_types=1);

namespace App;

use App\Core\Renderer;
use App\Core\Router;

class App
{
    public function run(): void
    {
        $response = Router::response();
        $renderer = new Renderer('../app/Views');
        echo $renderer->render($response);
    }
}