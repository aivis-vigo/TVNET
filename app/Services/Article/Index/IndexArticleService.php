<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Repositories\Article\PdoArticleRepository;

class IndexArticleService
{
    private PdoArticleRepository $pdoArticleRepository;

    public function __construct(
        PdoArticleRepository $pdoArticleRepository
    )
    {
        $this->pdoArticleRepository = $pdoArticleRepository;
    }

    public function execute(): array
    {
        return $this->pdoArticleRepository->all();
    }
}