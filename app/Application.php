<?php

declare(strict_types=1);

namespace App;

use App\Controllers\ArticleController;
use App\Repositories\ArticleRepository;
use App\Repositories\MysqlArticleRepository;
use FastRoute;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Dotenv\Dotenv;
use DI;

class Application
{
    public function run(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->safeLoad();

        $builder = new DI\ContainerBuilder();
        $builder->addDefinitions([
            ArticleRepository::class => Di\create(MysqlArticleRepository::class)
        ]);
        $container = $builder->build();

        $loader = new FilesystemLoader(__DIR__ . '/../resources/views/');
        $twig = new Environment($loader, ['debug' => true,]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/articles', [ArticleController::class, 'index']);
            $r->addRoute('GET', '/articles/create', [ArticleController::class, 'create']);
            $r->addRoute('POST', '/articles', [ArticleController::class, 'store']);
            $r->addRoute('GET', '/articles/{id:\d+}', [ArticleController::class, 'show']);
            $r->addRoute('GET', '/articles/{id:\d+}/edit', [ArticleController::class, 'edit']);
            $r->addRoute('POST', '/articles/{id:\d+}', [ArticleController::class, 'update']);
            $r->addRoute('POST', '/articles/{id:\d+}/delete', [ArticleController::class, 'delete']);
        });

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                // ... call $handler with $vars
                [$controller, $method] = $handler;
                $controller = $container->get($controller);
                $response = ($controller)->{$method}(...array_values($vars));
                switch (true) {
                    case $response instanceof ViewResponse:
                        echo $twig->render($response->getViewName() . '.twig', $response->getData());
                        break;
                    case $response instanceof RedirectResponse:
                        header('Location: ' . $response->getLocation());
                        break;
                }
                break;
        }
    }
}