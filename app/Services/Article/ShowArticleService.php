<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\MysqlArticleRepository;
use Doctrine\DBAL\Connection;

class ShowArticleService
{
    protected Connection $database;
    private ArticleREpository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new MysqlArticleRepository();
    }

    public function execute(string $id): Article
    {
        return $this->articleRepository->getById($id);
    }
}