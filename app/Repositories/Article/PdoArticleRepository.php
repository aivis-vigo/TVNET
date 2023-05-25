<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;
use App\Models\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class PdoArticleRepository implements ArticleRepository
{
    private Connection $connection;
    public function __construct()
    {
        $connectionParams = [
            'dbname' => 'users',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];
        $this->connection = DriverManager::getConnection($connectionParams);
    }

    public function all(): array
    {
        echo "<pre>";
        $queryBuilder = $this->connection->createQueryBuilder();
        $users = $queryBuilder->select("*")
            ->from('users')
            ->fetchAllAssociative();

        var_dump($users);
        $allUsers = [];
        foreach ($users as $user) {
            $allUsers[] = $this->buildUser($user);
        }
        return $allUsers;
    }

    public function selectById(string $id): ?Article
    {
        // select * from articles where id=$id
        return null;
    }

    private function buildUser(array $user): User
    {
        return new User(
            $user["id"],
            $user["name"],
            $user["username"],
            $user["email"],
            $user["address"]["city"],
            $user["company"]["name"]
        );
    }
}
