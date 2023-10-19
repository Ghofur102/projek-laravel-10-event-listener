<?php

use App\Http\Controllers\AuthenticateControllers;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticateControllers::class, "login"])->name("login");
    Route::post('/login_process', [AuthenticateControllers::class, "sign_in"])->name("process.login");
    Route::get('/register', [AuthenticateControllers::class, "register"])->name("view.register");
    Route::post('/register_process', [AuthenticateControllers::class, "sign_up"])->name("process.register");
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthenticateControllers::class, "logout"])->name("process.logout");
    Route::get('/', [AuthenticateControllers::class, "home"])->name("home");
    Route::get('/home', [AuthenticateControllers::class, "home"])->name("home");
    Route::post('/follow-account/{follow_id}/{sender_id}', [FollowersController::class, "process_follow"])->name("process.follow");
    Route::put('/read-notifaction/{id}', [NotificationController::class, "readNotification"])->name("read.notification");
});
