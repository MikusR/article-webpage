<?php

declare(strict_types=1);

namespace App\Controllers;

use App\RedirectResponse;
use App\Response;
use App\Services\Article\DeleteArticleService;
use App\Services\Article\IndexArticleService;
use App\Services\Article\ShowArticleService;
use App\Services\Article\StoreArticleService;
use App\Services\Article\UpdateArticleService;
use App\ViewResponse;

class ArticleController
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;
    private DeleteArticleService $deleteArticleService;
    private StoreArticleService $storeArticleService;
    private UpdateArticleService $updateArticleService;

    public function __construct(
        IndexArticleService $indexArticleService,
        ShowArticleService $showArticleService,
        DeleteArticleService $deleteArticleService,
        StoreArticleService $storeArticleService,
        UpdateArticleService $updateArticleService
    ) {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
        $this->deleteArticleService = $deleteArticleService;
        $this->storeArticleService = $storeArticleService;
        $this->updateArticleService = $updateArticleService;
    }

    public function index(): Response
    {
        $articles = $this->indexArticleService->execute();

        return new ViewResponse('articles/index', ['articles' => $articles]);
    }

    public function show(string $id): Response
    {
        $article = $this->showArticleService->execute($id);

        return new ViewResponse('articles/show', ['article' => $article]);
    }

    public function create(): Response
    {
        return new ViewResponse('articles/create');
    }

    public function store(): Response
    {
        $this->storeArticleService->execute($_POST['title'], $_POST['text']);

        return new RedirectResponse('/articles');
    }

    public function edit(string $id): Response
    {
        $article = $this->showArticleService->execute($id);

        return new ViewResponse('articles/edit', ['article' => $article]);
    }

    public function update(string $id): Response
    {
        $this->updateArticleService->execute($id, $_POST['title'], $_POST['text']);

        return new RedirectResponse('/articles/' . $id);
    }

    public function delete(string $id): Response
    {
        $this->deleteArticleService->execute($id);

        return new RedirectResponse('/articles');
    }
}