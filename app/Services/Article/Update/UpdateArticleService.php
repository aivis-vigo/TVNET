<?php declare(strict_types=1);

namespace App\Services\Article\Update;

use App\Repositories\Article\PdoArticleRepository;

class UpdateArticleService
{
    private PdoArticleRepository $pdoArticleRepository;

    public function __construct(PdoArticleRepository $pdoArticleRepository)
    {
        $this->pdoArticleRepository = $pdoArticleRepository;
    }

    public function execute(UpdateArticleRequest $request): UpdateArticleResponse
    {
        $article = $this->pdoArticleRepository->update(
            $request->id(),
            $request->title(),
            $request->body()
        );

        return new UpdateArticleResponse($article);
    }
}