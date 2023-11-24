<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\ArticleCollection;
use App\RedirectResponse;
use App\Response;
use App\ViewResponse;
use Carbon\Carbon;

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
        return new ViewResponse('articles/show', ['article' => $article]);
    }

    public function create(): Response
    {
        return new ViewResponse('articles/create');
    }

    public function store(): Response
    {
        $this->database->createQueryBuilder()
            ->insert('articles')
            ->values(
                [
                    'title' => ':title',
                    'text' => ':text',
                    'image' => ':image',
                    'date_created' => ':created'
                ]
            )->setParameters([
                'title' => $_POST['title'],
                'text' => $_POST['text'],
                'image' => 'https://placehold.co/600x400',
                'created' => Carbon::now('Europe/Riga')
            ])->executeQuery();
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
        $this->database->createQueryBuilder()
            ->update('articles')
            ->set('title', ':title')
            ->set('text', ':text')
            ->where('id', ':id')
            ->setParameters([
                'id' => $id,
                'title' => $_POST['title'],
                'text' => $_POST['text'],
                'modified' => Carbon::now('Europe/Riga')
            ])->executeQuery();
        return new RedirectResponse('/articles/' . $id);
    }

    public function delete()
    {
    }
}