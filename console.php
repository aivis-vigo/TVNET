<?php declare(strict_types=1);

use App\Services\Article\Index\IndexArticleServices;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Services\User\Index\IndexUserServices;
use App\Services\User\Show\ShowUserRequest;
use App\Services\User\Show\ShowUserService;

require_once 'vendor/autoload.php';

$command = $argv[1] ?? null;
$id = $argv[2] ?? null;

switch ($command) {
    case 'articles':
        if ($id == null) {
            $service = (new IndexArticleServices());
            $articles = $service->execute();

            echo "====================" . PHP_EOL;
            foreach ($articles as $article) {
                /** @var App\Models\Article $article */
                echo "->" . $article->title() . "<-" . PHP_EOL;
                echo PHP_EOL;
                echo $article->body() . PHP_EOL;
                echo "====================" . PHP_EOL;
            }
        } else {
            echo "Not found!" . PHP_EOL;
        }
        break;
    case 'article':
        $service = (new ShowArticleService());
        $response = $service->execute(new ShowArticleRequest($id));
        $article = $response->article();

        echo "====================" . PHP_EOL;
        echo "Article Nr. $id" . PHP_EOL;
        echo PHP_EOL;
        echo "->" . $article->title() . "<-" . PHP_EOL;
        echo PHP_EOL;
        echo $article->body() . PHP_EOL;
        echo "====================" . PHP_EOL;

        break;
    case 'users':
        if ($id == null) {
            $service = (new IndexUserServices());
            $users = $service->execute();

            echo "=====================" . PHP_EOL;
            foreach ($users as $user) {
                /** @var App\Models\User $user */
                echo "->" . $user->username() . "<-" . PHP_EOL;
                echo "Name: " . $user->name() . PHP_EOL;
                echo "e-mail: " . $user->email() . PHP_EOL;
                echo "City: " . $user->city() . PHP_EOL;
                echo "Job: " . $user->companyName() . PHP_EOL;
                echo "====================" . PHP_EOL;
            }
        } else {
            echo "Not found!" . PHP_EOL;
        }
        break;
    case 'user':
        $service = (new ShowUserService());
        $response = $service->execute(new ShowUserRequest($id));
        $user = $response->user();

        echo "====================" . PHP_EOL;
        echo "->" . $user->username() . "<-" . PHP_EOL;
        echo "Name: " . $user->name() . PHP_EOL;
        echo "e-mail: " . $user->email() . PHP_EOL;
        echo "City: " . $user->city() . PHP_EOL;
        echo "Job: " . $user->companyName() . PHP_EOL;
        echo "====================" . PHP_EOL;
         break;
    default:
        echo "Invalid command!" . PHP_EOL;
        break;
}