<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

class PdoArticleRepository implements ArticleRepository
{
    private Connection $connection;
    private QueryBuilder $queryBuilder;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['HOST'],
            'driver' => 'pdo_mysql'
        ];
        $this->connection = DriverManager::getConnection($connectionParams);
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }

    public function all(): array
    {
        $allUsers = [];

        $queryBuilder = $this->queryBuilder;

        $results = $queryBuilder
            ->select("*")
            ->from('articles')
            ->fetchAllAssociative();

        foreach ($results as $article) {
            $allUsers[] = $this->buildArticle((object) $article);
        }
        return $allUsers;
    }

    public function selectById(string $id): ?Article
    {
        $queryBuilder = $this->queryBuilder;

        $article = $queryBuilder
            ->select('*')
            ->from('articles')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->fetchAssociative();

        return $this->buildArticle((object) $article);
    }

    public function create(): string
    {
        $queryBuilder = $this->queryBuilder;
        if (isset($_REQUEST['title'])) {
            $queryBuilder
                ->insert('articles')
                ->values(
                    [
                        'user_id' => '?',
                        'title' => '?',
                        'body' => '?'
                    ]
                )
                ->setParameter(0, 1)
                ->setParameter(1, $_REQUEST['title'])
                ->setParameter(2, $_REQUEST['body'])
                ->executeQuery();

            return "Created successfully!";
        }
        return "";
    }

    public function read(string $id): Article
    {
        $queryBuilder = $this->queryBuilder;
        $post = $queryBuilder
            ->select("*")
            ->from('articles')
            ->where('id = ' . $id)
            ->fetchAssociative();

       $post = (object) $post;
        return new Article(
            $post->id,
            $post->user_id,
            $post->title,
            $post->body
        );
    }

    public function update(string $id, string $title, string $body): string
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->update('articles')
            ->set('title', '?')
            ->set('body', '?')
            ->setParameter(0, $title)
            ->setParameter(1, $body)
            ->where('id = ' . $id)
            ->executeQuery();
        return "Changes made successfully!";
    }

    public function delete(string $id): string
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->delete('articles')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery();
        return "Deleted successfully";
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