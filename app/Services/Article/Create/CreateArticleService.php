<?php declare(strict_types=1);

namespace App\Services\Article\Create;

use App\Repositories\Article\PdoArticleRepository;

class CreateArticleService
{
    private PdoArticleRepository $pdoArticleRepository;

    public function __construct(PdoArticleRepository $pdoArticleRepository)
    {
        $this->pdoArticleRepository = $pdoArticleRepository;
    }

    public function execute(CreateArticleRequest $request): array
    {
        return $this->pdoArticleRepository->all();
    }
}