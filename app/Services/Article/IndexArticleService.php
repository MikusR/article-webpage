<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Models\ArticleCollection;
use App\Repositories\ArticleRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $repository)
    {
        $this->articleRepository = $repository;
    }

    public function execute(): ArticleCollection
    {
        return $this->articleRepository->getAll();
    }
}