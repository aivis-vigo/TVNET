<?php declare(strict_types=1);

namespace App\Services\Article\Delete;

use App\Repositories\Article\PdoArticleRepository;

class DeleteArticleService
{
    private PdoArticleRepository $pdoArticleRepository;

    public function __construct(PdoArticleRepository $pdoArticleRepository)
    {
        $this->pdoArticleRepository = $pdoArticleRepository;
    }

    public function execute(DeleteArticleRequest $request): void
    {
        $this->pdoArticleRepository->delete(
            $request->id()
        );
    }
}