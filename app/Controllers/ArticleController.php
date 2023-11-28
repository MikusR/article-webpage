<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\ArticleCollection;
use App\RedirectResponse;
use App\Response;
use App\Services\Article\IndexArticleService;
use App\Services\Article\ShowArticleService;
use App\Services\Article\StoreArticleService;
use App\ViewResponse;
use Carbon\Carbon;

class ArticleController extends BaseController
{
    public function index(): Response
    {
        $service = new IndexArticleService();
        $articles = $service->execute();
        return new ViewResponse('articles/index', ['articles' => $articles]);
    }

    public function show(string $id): Response
    {
        $service = new ShowArticleService();
        $article = $service->execute($id);

        return new ViewResponse('articles/show', ['article' => $article]);
    }

    public function create(): Response
    {
        return new ViewResponse('articles/create');
    }

    public function store(): Response
    {
        $service = new StoreArticleService();
        $service->execute($_POST['title'], $_POST['text']);
        return new RedirectResponse('/articles');
    }

    public function edit(string $id): Response
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();
        $article = new Article(
            $data['title'],
            $data['text'],
            $data['image'],
            $data['date_created'],
            $data['date_modified'],
            (int)$data['id'],
        );
        return new ViewResponse('articles/edit', ['article' => $article]);
    }

    public function update(string $id): Response
    {
        return new RedirectResponse('/articles/' . $id);
    }

    public function delete(string $id): Response
    {
        $this->database->createQueryBuilder()
            ->delete('articles')
            ->where('id = :id')
            ->setParameters(
                ['id' => $id]
            )->executeQuery();
        return new RedirectResponse('/articles');
    }
}