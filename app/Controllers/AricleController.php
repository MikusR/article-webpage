<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\ArticleCollection;
use App\Response;
use App\ViewResponse;

class AricleController extends BaseController
{
    public function index(): Response
    {
        $articles = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->fetchAllAssociative();

        $articlesCollection = new ArticleCollection();
        foreach ($articles as $article) {
            $articlesCollection->add(
                new Article(
                    $article['title'],
                    $article['text'],
                    $article['image'],
                    $article['date_created'],
                    $article['date_modified'],
                    (int)$article['id'],
                )
            );
        }
        return new ViewResponse('articles/index', ['articles' => $articlesCollection]);
    }

    public function show(string $id): Response
    {
        return new ViewResponse('articles/show', ['id' => $id]);
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}