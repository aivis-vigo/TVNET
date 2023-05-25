<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;
use PDO;

class PdoArticleRepository implements ArticleRepository
{
    private PDO $connection;

    public function __construct()
    {
        $dsn = "mysql:host=localhost;port=3306;dbname=users;user=root;password=---;charset=utf8mb4";
        $this->connection = new PDO($dsn);
    }

    public function all(): array
    {
        $allUsers = [];

        $statement = $this->connection->prepare("select * from articles");
        $statement->execute();

        $articles = $statement->fetchAll(PDO::FETCH_CLASS);

        foreach ($articles as $article) {
            $allUsers[] = $this->buildArticle($article);
        }
        return $allUsers;
    }

    public function selectById(string $id): ?Article
    {
        $statement = $this->connection->prepare("select * from articles where id = $id");
        $statement->execute();

        $article = $statement->fetch();

        return $this->buildArticle((object) $article);
    }

    public function create(): void
    {
        $sql = "INSERT INTO articles (user_id, title, body) VALUES (1, '{$_REQUEST['title']}', '{$_REQUEST['body']}')";
        $statement= $this->connection->prepare($sql);
        $statement->execute();
    }

    private function buildArticle(\stdClass $article): Article
    {
        return new Article(
            $article->id,
            $article->user_id,
            $article->title,
            $article->body
        );
    }
}