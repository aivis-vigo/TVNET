<?php declare(strict_types=1);

namespace App\Console;

use App\Models\Article;
use App\Models\User;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Services\User\Index\IndexUserService;
use App\Services\User\Show\ShowUserRequest;
use App\Services\User\Show\ShowUserService;

class Console
{
    private string $command;
    private ?string $id;

    public function __construct(array $argv)
    {
        $this->command = $argv[1];
        $this->id = $argv[2] ?? null;
    }

    public function run()
    {
        switch ($this->command) {
            case "articles":
                if ($this->id != null) {
                    $service = (new ShowArticleService());
                    $response = $service->execute(new ShowArticleRequest($this->id));
                    $this->showSingleArticle($response->article());
                }

                $service = (new IndexArticleService());
                $articles = $service->execute();
                $this->displayArticles($articles);

                exit;
            case "users":
                if ($this->id != null) {
                    $service = (new ShowUserService());
                    $response = $service->execute(new ShowUserRequest($this->id));
                    $this->showSingleUser($response->user());
                }

                $service = (new IndexUserService());
                $users = $service->execute();
                $this->displayUsers($users);

                exit;
            default:
                echo "Invalid command!" . PHP_EOL;

                exit;
        }
    }

    public function displayArticles(array $articles)
    {
        echo "====================" . PHP_EOL;
        foreach ($articles as $article) {
            /** @var Article $article */
            echo "->" . $article->title() . "<-" . PHP_EOL;
            echo PHP_EOL;
            echo $article->body() . PHP_EOL;
            echo "====================" . PHP_EOL;
        }
    }

    public function showSingleArticle(Article $article)
    {
        echo "->" . $article->title() . "<-" . PHP_EOL;
        echo PHP_EOL;
        echo $article->body() . PHP_EOL;
    }

    public function displayUsers(array $users)
    {
        echo "=====================" . PHP_EOL;
        foreach ($users as $user) {
            /** @var User $user */
            echo "->" . $user->username() . "<-" . PHP_EOL;
            echo "Name: " . $user->name() . PHP_EOL;
            echo "e-mail: " . $user->email() . PHP_EOL;
            echo "City: " . $user->city() . PHP_EOL;
            echo "Job: " . $user->companyName() . PHP_EOL;
            echo "====================" . PHP_EOL;
        }
    }

    public function showSingleUser(User $user)
    {
        echo "->" . $user->username() . "<-" . PHP_EOL;
        echo "Name: " . $user->name() . PHP_EOL;
        echo "e-mail: " . $user->email() . PHP_EOL;
        echo "City: " . $user->city() . PHP_EOL;
        echo "Job: " . $user->companyName() . PHP_EOL;
    }
}