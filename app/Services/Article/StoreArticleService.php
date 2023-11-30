<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Models\Article;
use App\Repositories\ArticleRepository;

class StoreArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $repository)
    {
        $this->articleRepository = $repository;
    }

    public function execute(string $title, string $text): void
    {
        $article = new Article(
            $title,
            $text,
            'pikture'
        );
        $this->articleRepository->save($article);
    }
}