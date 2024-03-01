<?php

declare(strict_types=1);

use Framework\{TemplateEngine, Database, Container};
use App\config\paths;
use App\Services\{ValidatorService, UserService, HomeService, FileService, MusicService, SpendingPlanService, ProfileService, workQueueService, dppService, historyService, settingsService, workDetailsService};

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
    HomeService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new HomeService($db);
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
    },
    ProfileService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new ProfileService($db);
    },
    workQueueService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new workQueueService($db);
    },
    workDetailsService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new workDetailsService($db);
    },
    settingsService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new settingsService($db);
    },
    dppService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new dppService($db);
    },
    historyService::class => function (container $container) {
        $db = $container->get(Database::class);
        return new historyService($db);
    }

];
