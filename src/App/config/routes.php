<?php

declare(strict_types=1);

namespace App\config;

use Framework\App;

use App\Controllers\{HomeController, RegisterUserController, LoginController, TransactionController, ReceiptController, ErrorController, playerController, KaraokeController, playlistController, SpendingPlanController, ProfileController, dppController, historyController, WorkQueueController, settingsController, vehicleController, workDetailsController};
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

    // * This is for the Karaoke Pages
    $app->get('/karaoke', [KaraokeController::class, 'karaokeMain'])->add(AuthRequiredMiddleware::class);
    $app->post('/karaoke', [KaraokeController::class, 'addSong'])->add(AuthRequiredMiddleware::class);
    $app->get('/karaoke/edit', [KaraokeController::class, 'editSong'])->add(AuthRequiredMiddleware::class);
    $app->post('/karaoke/edit', [KaraokeController::class, 'editSongSave'])->add(AuthRequiredMiddleware::class);
    $app->get('/karaoke/delete', [KaraokeController::class, 'deleteSong'])->add(AuthRequiredMiddleware::class);
    $app->post('/karaoke/addsong', [KaraokeController::class, 'addSongtoDB'])->add(AuthRequiredMiddleware::class);
    $app->get('/karaoke/song', [KaraokeController::class, 'addSongtoCue'])->add(AuthRequiredMiddleware::class);
    $app->get('/livesearch', [KaraokeController::class, 'liveSearch'])->add(AuthRequiredMiddleware::class);
    $app->get('/player', [playerController::class, 'player'])->add(AuthRequiredMiddleware::class);

    // * This is the routes for the spending plan page
    $app->get('/spendingplan', [SpendingPlanController::class, 'viewall'])->add(AuthRequiredMiddleware::class);
    $app->get('/spendingplan/addsaa', [SpendingPlanController::class, 'searchToAddSaa'])->add(AuthRequiredMiddleware::class);
    $app->post('/spendingplan/addsaa', [SpendingPlanController::class, 'addSaa'])->add(AuthRequiredMiddleware::class);
    $app->get('/spendingplan/viewsaa', [SpendingPlanController::class, 'viewSaa'])->add(AuthRequiredMiddleware::class);
    $app->get('/spendingplan/deletesaa', [SpendingPlanController::class, 'deleteSaa'])->add(AuthRequiredMiddleware::class);

    // * This is for the profile and Work Detail page
    $app->get('/profile', [ProfileController::class, 'viewProfile'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/return', [ProfileController::class, 'backTo'])->add(AuthRequiredMiddleware::class);
    $app->get('/{viewedFrom}/work/{id}', [WorkQueueController::class, 'viewWorkList'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile', [ProfileController::class, 'addwork'])->add(AuthRequiredMiddleware::class);
    $app->get('/{viewedFrom}/details/{id}', [workDetailsController::class, 'viewWorkDetails'])->add(AuthRequiredMiddleware::class);
    $app->get('/{viewedFrom}/details/added/{id}', [workDetailsController::class, 'viewAddedWorkDetails'])->add(AuthRequiredMiddleware::class);
    $app->get('/{view}/details/sub/{id}/{sub}', [workDetailsController::class, 'viewUpdates'])->add(AuthRequiredMiddleware::class);
    $app->get('/{view}/details/added/sub/{id}/{sub}', [workDetailsController::class, 'viewAddedUpdates'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/details/edit/{id}', [workDetailsController::class, 'renderEditWorkModal'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/edit/save', [workDetailsController::class, 'saveEditedWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/delete', [workDetailsController::class, 'deleteWork'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/details/edit/sub/{id}', [workDetailsController::class, 'editSubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/edit/sub/save', [workDetailsController::class, 'saveEditSubWork'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/details/delete/sub/{id}', [workDetailsController::class, 'renderDeleteSubWorkModel'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/delete/sub', [workDetailsController::class, 'deleteSubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/add/sub', [workDetailsController::class, 'addSubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/delete/update', [workDetailsController::class, 'deleteUpdate'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/update', [workDetailsController::class, 'updateWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/update/sub', [workDetailsController::class, 'updateSubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/comply/sub', [workDetailsController::class, 'complySubWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/details/comply', [workDetailsController::class, 'complyWork'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/details/work/approve', [workDetailsController::class, 'approveCompliance'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/details/work/return', [workDetailsController::class, 'returnCompliance'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/viewfile', [ProfileController::class, 'viewFile'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/file/{file}', [ProfileController::class, 'renderFile'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/update/edit', [workDetailsController::class, 'renderEditUpdate'])->add(AuthRequiredMiddleware::class);
    $app->get('/profile/{viewedFrom}/{id}', [ProfileController::class, 'renderWorkHistory'])->add(AuthRequiredMiddleware::class);

    $app->post('/profile/update/edit/save', [workDetailsController::class, 'saveEditUpdate'])->add(AuthRequiredMiddleware::class);


    // * This is for the History Page
    $app->get('/history', [historyController::class, 'workHistory'])->add(AuthRequiredMiddleware::class);
    $app->get('/{viewedFrom}/details/{id}', [workDetailsController::class, 'workHistory'])->add(AuthRequiredMiddleware::class);
    $app->get('/{viewedFrom}/details/sub/{id}', [workDetailsController::class, 'workHistory'])->add(AuthRequiredMiddleware::class);



    // Leetcode problem solver
    // $app->get('/special', [HomeController::class, 'special'])->add(AuthRequiredMiddleware::class);


    $app->get('/dashboard/profile/{id}', [HomeController::class, 'renderUserProfile'])->add(AuthRequiredMiddleware::class);

    // * This is for viewing profile pictures and files uploaded
    $app->get('/profile/{profilePic}', [ProfileController::class, 'renderProfPic'])->add(AuthRequiredMiddleware::class);

    $app->get('/history', [ProfileController::class, 'workHistory'])->add(AuthRequiredMiddleware::class);
    $app->get('/history/workdetail', [ProfileController::class, 'viewWorkHistory'])->add(AuthRequiredMiddleware::class);

    $app->get('/office/history', [ProfileController::class, 'officeHistory'])->add(AuthRequiredMiddleware::class);

    $app->get('/section/dpp', [dppController::class, 'dppProfile'])->add(AuthRequiredMiddleware::class);
    $app->post('/section/dpp/addproc', [dppController::class, 'addProcurement'])->add(AuthRequiredMiddleware::class);

    $app->get('/section/vehicle', [vehicleController::class, 'renderVehiclePage'])->add(AuthRequiredMiddleware::class);
    $app->post('/section/vehicle/add', [vehicleController::class, 'addVehicle'])->add(AuthRequiredMiddleware::class);
    $app->get('/section/vehicle/details/{id}', [vehicleController::class, 'vehicleDetails'])->add(AuthRequiredMiddleware::class);
    $app->post('/section/vehicle/update/status', [vehicleController::class, 'updateVehicleStatus'])->add(AuthRequiredMiddleware::class);
    $app->post('/section/vehicle/update/details', [vehicleController::class, 'updateVehicleDetails'])->add(AuthRequiredMiddleware::class);
    $app->get('/section/vehicle/delete', [vehicleController::class, 'deleteVehicle'])->add(AuthRequiredMiddleware::class);
    $app->post('/section/vehicle/addwork', [vehicleController::class, 'addVehicleWork'])->add(AuthRequiredMiddleware::class);
    $app->post('/section/vehicle/renew', [vehicleController::class, 'renewVehicle'])->add(AuthRequiredMiddleware::class);



    $app->get('/settings', [settingsController::class, 'userSettings'])->add(AuthRequiredMiddleware::class);
    $app->post('/settings/save', [settingsController::class, 'updateUser'])->add(AuthRequiredMiddleware::class);

    $app->setErrorHandler([ErrorController::class, 'notFound']);
}
