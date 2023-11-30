<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Repositories\ArticleRepository;

class DeleteArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $repository)
    {
        $this->articleRepository = $repository;
    }

    public function execute(string $id): void
    {
        $article = $this->articleRepository->getById($id);
        $this->articleRepository->delete($article);
    }
}