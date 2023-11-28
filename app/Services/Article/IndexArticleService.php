<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Models\ArticleCollection;
use App\Repositories\ArticleRepository;
use App\Repositories\MysqlArticleRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new MysqlArticleRepository();
    }

    public function execute(): ArticleCollection
    {
        return $this->articleRepository->getAll();
    }
}