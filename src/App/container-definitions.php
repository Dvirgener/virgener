<?php

declare(strict_types=1);

use Framework\{TemplateEngine, Database, Container};
use App\config\paths;
use App\Services\{ValidatorService, UserService, TransactionService, FileService, MusicService, storeMusicHere,SpendingPlanService};

return [
    // * 7. return an arrow function with the class name as key and function that create a new instance of the class as value
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW),
    ValidatorService::class => fn () => new ValidatorService(),
    Database::class => fn () => new Database(
        $_ENV['DB_DRIVER'],
        [
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME']
        ],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    ),
    UserService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new UserService($db);
    },
    TransactionService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new TransactionService($db);
    },
    FileService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new FileService($db);
    },
    MusicService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new MusicService($db);
    },
    SpendingPlanService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new SpendingPlanService($db);
    }



];
