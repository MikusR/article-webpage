<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticleCollection;

interface ArticleRepository
{
    public function getAll(): ArticleCollection;

    public function getById(int $id): ?Article;

    public function save(Article $article): void;

    public function delete(Article $article): void;
}