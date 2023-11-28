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
        foreach ($articles as $data) {
            $articlesCollection->add(
                $this->buildModel($data)
            );
        }
        return $articlesCollection;
    }

    public function getById(string $id): ?Article
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();

        return $this->buildModel($data);
    }

    public function save(Article $article): void
    {
        $builder = $this->database->createQueryBuilder();
        if ($article->getId()) {
            $builder->update('articles')
                ->set('title', ':title')
                ->set('text', ':text')
                ->set('date_modified', ':modified')
                ->where('id = :id')
                ->setParameters([
                    'title' => $article->getTitle(),
                    'text' => $article->getText(),
                    'id' => $article->getId(),
                    'modified' => $article->getModified()
                ])->executeQuery();
        } else {
            $builder->insert('articles');
            $builder->values(
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
    }

    public function delete(Article $article): void
    {
        $this->database->createQueryBuilder()
            ->delete('articles')
            ->where('id = :id')
            ->setParameters(
                ['id' => $article->getId()]
            )->executeQuery();
    }

    private function buildModel(array $data): Article
    {
        return new Article(
            $data['title'],
            $data['text'],
            $data['image'],
            $data['date_created'],
            $data['date_modified'],
            (int)$data['id']
        );
    }
}