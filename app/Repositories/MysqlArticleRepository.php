<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticleCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class MysqlArticleRepository implements ArticleRepository
{
    protected Connection $database;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => $_ENV['DBNAME'],
            'user' => $_ENV['USER'],
            'host' => $_ENV['HOST'],
            'driver' => $_ENV['DRIVER'],
        ];
        $this->database = DriverManager::getConnection($connectionParams);
    }

    public function getAll(): ArticleCollection
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
        return $articlesCollection;
    }

    public function getById(int $id): ?Article
    {
        // TODO: Implement getById() method.
    }

    public function save(Article $article): void
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
                'title' => $article->getTitle(),
                'text' => $article->getText(),
                'image' => $article->getImage(),
                'created' => $article->getCreated()
            ])->executeQuery();
    }

    public function delete(Article $article): void
    {
        // TODO: Implement delete() method.
    }
}