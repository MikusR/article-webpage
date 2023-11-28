<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\ArticleCollection;
use App\RedirectResponse;
use App\Response;
use App\Services\Article\DeleteArticleService;
use App\Services\Article\IndexArticleService;
use App\Services\Article\ShowArticleService;
use App\Services\Article\StoreArticleService;
use App\Services\Article\UpdateArticleService;
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
        $service = new ShowArticleService();
        $article = $service->execute($id);
        return new ViewResponse('articles/edit', ['article' => $article]);
    }

    public function update(string $id): Response
    {
        $service = new UpdateArticleService();
        $service->execute($id, $_POST['title'], $_POST['text']);
        return new RedirectResponse('/articles/' . $id);
    }

    public function delete(string $id): Response
    {
        $service = new DeleteArticleService();
        $service->execute($id);
        return new RedirectResponse('/articles');
    }
}