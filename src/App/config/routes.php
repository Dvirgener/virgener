<?php

declare(strict_types=1);

namespace App\config;

use Framework\App;

use App\Controllers\{HomeController, RegisterUserController, LoginController, TransactionController, ReceiptController, ErrorController, playerController, KaraokeController, playlistController, SpendingPlanController, ProfileController};
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


    $app->get('/spendingplan', [SpendingPlanController::class, 'viewall'])->add(AuthRequiredMiddleware::class);
    $app->get('/spendingplan/addsaa', [SpendingPlanController::class, 'searchToAddSaa'])->add(AuthRequiredMiddleware::class);
    $app->post('/spendingplan/addsaa', [SpendingPlanController::class, 'addSaa'])->add(AuthRequiredMiddleware::class);
    $app->get('/spendingplan/viewsaa', [SpendingPlanController::class, 'viewSaa'])->add(AuthRequiredMiddleware::class);
    $app->get('/spendingplan/deletesaa', [SpendingPlanController::class, 'deleteSaa'])->add(AuthRequiredMiddleware::class);

    $app->get('/profile', [ProfileController::class, 'viewProfile'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/workdetail', [ProfileController::class, 'viewWork'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/workdetail/viewfile', [ProfileController::class, 'viewFile'])->add(AuthRequiredMiddleware::class);
    $app->get('/settings', [ProfileController::class, 'userSettings'])->add(AuthRequiredMiddleware::class);
    $app->post('/settings', [ProfileController::class, 'updateUser'])->add(AuthRequiredMiddleware::class);

    $app->get('/profile/{profilePic}', [ProfileController::class, 'renderProfPic'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/file/{file}', [ProfileController::class, 'renderFile'])->add(AuthRequiredMiddleware::class);

    $app->post('/profile/addwork', [ProfileController::class, 'addwork'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/editwork', [ProfileController::class, 'saveEditWork'])->add(AuthRequiredMiddleware::class);
    $app->get('/editwork', [ProfileController::class, 'editWork'])->add(AuthRequiredMiddleware::class);
    $app->get('/deletework', [ProfileController::class, 'deleteWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/confirmdeletework', [ProfileController::class, 'confirmDeleteWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/addsubwork', [ProfileController::class, 'addSubWork'])->add(AuthRequiredMiddleware::class);
    $app->get('/editsubwork', [ProfileController::class, 'editSubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/editsubwork', [ProfileController::class, 'saveEditSubWork'])->add(AuthRequiredMiddleware::class);
    $app->get('/deletesubwork', [ProfileController::class, 'deleteSubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/confirmdeletesubwork', [ProfileController::class, 'confirmDeleteSubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/updatework', [ProfileController::class, 'updateWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/updatesubwork', [ProfileController::class, 'updateSubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/complysubwork', [ProfileController::class, 'complySubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/complywork', [ProfileController::class, 'complyWork'])->add(AuthRequiredMiddleware::class);


    $app->get('/history', [ProfileController::class, 'workHistory'])->add(AuthRequiredMiddleware::class);
    $app->get('/history/workdetail', [ProfileController::class, 'viewWorkHistory'])->add(AuthRequiredMiddleware::class);

    $app->get('/office/history', [ProfileController::class, 'officeHistory'])->add(AuthRequiredMiddleware::class);



    $app->setErrorHandler([ErrorController::class, 'notFound']);
}
