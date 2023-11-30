<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Models\Article;
use App\Repositories\ArticleRepository;

class ShowArticleService
{
    private ArticleREpository $articleRepository;

    public function __construct(ArticleRepository $repository)
    {
        $this->articleRepository = $repository;
    }

    public function execute(string $id): Article
    {
        return $this->articleRepository->getById($id);
    }
}