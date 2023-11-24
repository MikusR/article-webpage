<?php

namespace App\Controllers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class BaseController
{
    protected Connection $database;

    public function __construct()
    {
        //todo .env
        $connectionParams = [
            'dbname' => 'articlesdb',
            'user' => 'root',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];
        $this->database = DriverManager::getConnection($connectionParams);
    }
}