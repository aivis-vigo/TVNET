<?php declare(strict_types=1);

namespace App;

use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\JsonPlaceholderCommentRepository;
use App\Repositories\User\JsonPlaceholderUsersRepository;
use App\Repositories\User\UserRepository;
use DI\ContainerBuilder;

class Container
{
    public static function build()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            ArticleRepository::class => new JsonPlaceholderArticleRepository(),
            UserRepository::class => new JsonPlaceholderUsersRepository(),
            CommentRepository::class => new JsonPlaceholderCommentRepository()
        ]);
        return $builder->build();
    }
}