<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

class CombinedArticleRepository implements ArticleRepository
{
    private ArticleRepository $jsonPlaceholderArticleRepository;
    private ArticleRepository $randomArticleRepository;
    private PdoArticleRepository $pdoArticleRepository;
    private Connection $connection;
    private QueryBuilder $queryBuilder;

    public function __construct()
    {
        $this->jsonPlaceholderArticleRepository = new JsonPlaceholderArticleRepository();
        $this->randomArticleRepository = new RandomArticleRepository();
        $this->pdoArticleRepository = new PdoArticleRepository();

        $connectionParams = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['HOST'],
            'driver' => $_ENV['DRIVER']
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }

    public function all(): array
    {
        $jsonArticles = $this->jsonPlaceholderArticleRepository->all();
        $randomArticles = $this->randomArticleRepository->all();
        $pdoArticles = $this->pdoArticleRepository->all();

        $allArticles = array_merge(
            $jsonArticles,
            $randomArticles,
            $pdoArticles
        );

        shuffle($allArticles);

        return $allArticles;
    }

    public function selectById(string $id): ?Article
    {
        return $this->jsonPlaceholderArticleRepository->selectById($id);
    }

    public function create(Article $article): void
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->insert('articles')
            ->values(
                [
                    'user_id' => '?',
                    'title' => '?',
                    'body' => '?'
                ]
            )
            ->setParameter(0, $article->userId())
            ->setParameter(1, $article->title())
            ->setParameter(2, $article->body())
            ->executeQuery();

        $article->setId((int)$this->connection->lastInsertId());
    }

    public function read(string $id): Article
    {
    }

    public function update(
        int    $id,
        string $title,
        string $body
    ): void
    {

    }

    public function delete(string $id): void
    {

    }
}