<?php declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

class PdoUserRepository
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

    public function create(array $user): void
    {
        $this->queryBuilder
            ->insert('registeredUsers')
            ->values(
                [
                    'e_mail' => '?',
                    'password' => '?'
                ]
            )
            ->setParameter(0, $user['email'])
            ->setParameter(1, $user['password'])
            ->executeQuery();
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
}