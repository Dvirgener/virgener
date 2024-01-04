<?php

declare(strict_types=1);

namespace App\config;

use Framework\App;

use App\Controllers\{HomeController, RegisterUserController, LoginController, TransactionController, ReceiptController, ErrorController, playerController, KaraokeController, playlistController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};


function registerRoutes(App $app)
{
    // * 11. run get/post methods of the app class to store these values to the router class
    $app->get('/', [HomeController::class, 'home'])->add(AuthRequiredMiddleware::class);
    $app->get('/playlist', [playlistController::class, 'playlist'])->add(AuthRequiredMiddleware::class);
    $app->get('/register', [RegisterUserController::class, 'registerView'])->add(GuestOnlyMiddleware::class);
    $app->post('/register', [RegisterUserController::class, 'register'])->add(GuestOnlyMiddleware::class);
    $app->get('/login', [LoginController::class, 'loginView'])->add(GuestOnlyMiddleware::class);
    $app->post('/login', [LoginController::class, 'login'])->add(GuestOnlyMiddleware::class);
    $app->get('/logout', [LoginController::class, 'logout'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction', [TransactionController::class, 'createView'])->add(AuthRequiredMiddleware::class);


    $app->get('/karaoke', [KaraokeController::class, 'karaokeMain'])->add(AuthRequiredMiddleware::class);
    $app->post('/karaoke', [KaraokeController::class, 'addSong'])->add(AuthRequiredMiddleware::class);
    $app->get('/karaoke/edit', [KaraokeController::class, 'editSong'])->add(AuthRequiredMiddleware::class);
    $app->post('/karaoke/edit', [KaraokeController::class, 'editSongSave'])->add(AuthRequiredMiddleware::class);
    $app->get('/karaoke/delete', [KaraokeController::class, 'deleteSong'])->add(AuthRequiredMiddleware::class);
    $app->post('/karaoke/addsong', [KaraokeController::class, 'addSongtoDB'])->add(AuthRequiredMiddleware::class);
    $app->get('/karaoke/song', [KaraokeController::class, 'addSongtoCue'])->add(AuthRequiredMiddleware::class);
    $app->get('/livesearch', [KaraokeController::class, 'liveSearch'])->add(AuthRequiredMiddleware::class);


    $app->post('/transaction', [TransactionController::class, 'create'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/{transaction}', [TransactionController::class, 'editView'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction/{transaction}', [TransactionController::class, 'edit'])->add(AuthRequiredMiddleware::class);
    $app->delete('/transaction/{transaction}', [TransactionController::class, 'delete'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/{transaction}/receipt', [ReceiptController::class, 'uploadView'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction/{transaction}/receipt', [ReceiptController::class, 'upload'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/{transaction}/receipt/{receipt}', [ReceiptController::class, 'download'])->add(AuthRequiredMiddleware::class);
    $app->delete('/transaction/{transaction}/receipt/{receipt}', [ReceiptController::class, 'delete'])->add(AuthRequiredMiddleware::class);
    $app->get('/player', [playerController::class, 'player'])->add(AuthRequiredMiddleware::class);

    $app->setErrorHandler([ErrorController::class, 'notFound']);
}
