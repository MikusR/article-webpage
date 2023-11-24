<?php

namespace App\Controllers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class BaseController
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
}