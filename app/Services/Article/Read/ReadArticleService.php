<?php declare(strict_types=1);

namespace App\Services\Article\Read;

use App\Repositories\Article\PdoArticleRepository;

class ReadArticleService
{
    private PdoArticleRepository $pdoArticleRepository;

    public function __construct(PdoArticleRepository $pdoArticleRepository)
    {
        $this->pdoArticleRepository = $pdoArticleRepository;
    }

    public function execute(ReadArticleRequest $request): ReadArticleResponse
    {
        $article = $this->pdoArticleRepository->read($request->id());

        return new ReadArticleResponse($article);
    }
}