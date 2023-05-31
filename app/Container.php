<?php declare(strict_types=1);

namespace App;

use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\PdoArticleRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\JsonPlaceholderCommentRepository;
use App\Repositories\User\PdoUserRepository;
use App\Repositories\User\UserRepository;
use DI\ContainerBuilder;

class Container
{
    public static function build()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            ArticleRepository::class => new PdoArticleRepository(),
            UserRepository::class => new PdoUserRepository(),
            CommentRepository::class => new JsonPlaceholderCommentRepository()
        ]);
        return $builder->build();
    }
}