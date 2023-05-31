<?php declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

class PdoUserRepository implements UserRepository
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
            'driver' => $_ENV['DRIVER']
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }

    public function all(): array
    {
        return $this->queryBuilder
            ->select("*")
            ->from('registeredUsers')
            ->fetchAllAssociative();
    }

    public function selectById(string $id): ?User
    {
        $user = $this->queryBuilder
            ->select('*')
            ->from('registeredUsers')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->fetchAssociative();

        if (!$user) {
            return null;
        }

        return new User(
            $user['name'],
            $user['e_mail'],
            $user['password'],
            $user['id'],
        );
    }

    public function selectByEmail(string $email): ?User
    {
        $user = $this->queryBuilder
            ->select('*')
            ->from('registeredUsers')
            ->where('e_mail = ?')
            ->setParameter(0, $email)
            ->fetchAssociative();

        return new User(
            $user['name'],
            $user['e_mail'],
            $user['password'],
            $user['id']
        );
    }

    public function create(User $user): void
    {


            $this->queryBuilder
                ->insert('registeredUsers')
                ->values(
                    [
                        'e_mail' => '?',
                        'password' => '?',
                        'name' => '?'
                    ]
                )
                ->setParameter(0, $user->email())
                ->setParameter(1, $user->password())
                ->setParameter(2, $user->name())
                ->executeQuery();

            $user->setId((int) $this->connection->lastInsertId());
    }

    public function read(array $user): \stdClass
    {
        $userFound = $this->queryBuilder
            ->select('*')
            ->from('registeredUsers')
            ->where('e_mail = ?')
            ->setParameter(0, $user['email'])
            ->fetchAssociative();

        return (object) $userFound;
    }

    public function fetchUserArticles(string $id): array
    {
        return [];
    }
}