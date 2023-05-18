<?php declare(strict_types=1);

use App\Services\Article\Index\IndexArticleServices;

require_once 'vendor/autoload.php';

$command = $argv[1] ?? null;
$id = $argv[2] ?? null;

switch ($command) {
    case 'articles':
        if ($id == null) {
            $service = (new IndexArticleServices());
            $articles = $service->execute();

            echo "XXXXXXXXX---NEWS---XXXXXXXX" . PHP_EOL;
            foreach ($articles as $article) {
                /** @var App\Models\Article $article */
                echo $article->title() . PHP_EOL;
                echo PHP_EOL;
                echo $article->body() . PHP_EOL;
                echo "XXXXXXXXXXXXXXXXXXXXXXXXXXX" . PHP_EOL;
            }
        } else {
            //show
        }
        break;
    case 'users':
        if ($id == null) {

        } else {
            //show func
        }
        break;
    default:
        echo "Invalid command!" . PHP_EOL;
        break;
}