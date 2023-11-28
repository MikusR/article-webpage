<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Repositories\ArticleRepository;
use App\Repositories\MysqlArticleRepository;
use Carbon\Carbon;

class UpdateArticleService
{

    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new MysqlArticleRepository();
    }

    public function execute(string $id): void
    {
        $this->articleRepository->save($id);
    }

}