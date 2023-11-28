<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Repositories\ArticleRepository;
use App\Repositories\MysqlArticleRepository;

class UpdateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new MysqlArticleRepository();
    }

    public function execute(string $id, string $title, string $text): void
    {
        $article = $this->articleRepository->getById($id);
        $article->update([
            'title' => $title,
            'text' => $text
        ]);
        $this->articleRepository->save($article);
    }

}