<?php

declare(strict_types=1);

namespace App\Models;

class ArticleCollection
{
    private array $articles;

    public function __construct(array $articles = [])
    {
        $this->articles = $articles;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }
}