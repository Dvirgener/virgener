<?php

declare(strict_types=1);

namespace App\config;

use Framework\App;

use App\Controllers\{HomeController, AboutPageController, RegisterUserController, LoginController, TransactionController, ReceiptController, ErrorController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};


function registerRoutes(App $app)
{
    // * 11. run get/post methods of the app class to store these values to the router class
    $app->get('/', [HomeController::class, 'home'])->add(AuthRequiredMiddleware::class);
    $app->get('/about', [AboutPageController::class, 'aboutPage']);
    $app->get('/register', [RegisterUserController::class, 'registerView'])->add(GuestOnlyMiddleware::class);
    $app->post('/register', [RegisterUserController::class, 'register'])->add(GuestOnlyMiddleware::class);
    $app->get('/login', [LoginController::class, 'loginView'])->add(GuestOnlyMiddleware::class);
    $app->post('/login', [LoginController::class, 'login'])->add(GuestOnlyMiddleware::class);
    $app->get('/logout', [LoginController::class, 'logout'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction', [TransactionController::class, 'createView'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction', [TransactionController::class, 'create'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/{transaction}',[TransactionController::class,'editView'])->add(AuthRequiredMiddleware::class); 
    $app->post('/transaction/{transaction}',[TransactionController::class,'edit'])->add(AuthRequiredMiddleware::class); 
    $app->delete('/transaction/{transaction}',[TransactionController::class,'delete'])->add(AuthRequiredMiddleware::class); 
    $app->get('/transaction/{transaction}/receipt',[ReceiptController::class,'uploadView'])->add(AuthRequiredMiddleware::class); 
    $app->post('/transaction/{transaction}/receipt',[ReceiptController::class,'upload'])->add(AuthRequiredMiddleware::class); 
    $app->get('/transaction/{transaction}/receipt/{receipt}',[ReceiptController::class,'download'])->add(AuthRequiredMiddleware::class); 
    $app->delete('/transaction/{transaction}/receipt/{receipt}',[ReceiptController::class,'delete'])->add(AuthRequiredMiddleware::class); 

    $app->setErrorHandler([ErrorController::class,'notFound']);
}
