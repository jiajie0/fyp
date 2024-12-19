<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameStoreController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RecommendedController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsPlayer;
use App\Http\Middleware\IsDeveloper;
use App\Http\Middleware\IsStaff;

Route::post('/update-player-score', [PlayerController::class, 'updatePlayerScore']);


//testing button
Route::post('/games/{gameId}/add-hour', [GameStoreController::class, 'addPlayTime'])->name('game.addHour');
Route::post('/game-store/{gameId}/add-achievement', [GameStoreController::class, 'addAchievementsCount'])->name('game-store.add-achievement');


Route::get('/game/recommended', [GameController::class, 'recommended'])->name('game.recommended');






// Route::get('/game/recommended', [RecommendedController::class, 'show'])->name('game.recommended');


Route::get('/', [GameController::class, 'showWelcomePage'])->name('welcome');
Route::get('/game/{game}/detail', [GameController::class, 'showGameDetails'])->name('game.detail');
Route::post('/game/{gameID}/add-to-store', [GameStoreController::class, 'addToGameStore'])->name('game.addToStore');
Route::post('/game/{gameID}/rate', [RatingController::class, 'store'])->name('game.rate');
Route::get('/rating/{ratingID}/edit', [RatingController::class, 'edit'])->name('game.editRating');
Route::put('/rating/{ratingID}/update', [RatingController::class, 'update'])->name('game.updateRating');
Route::delete('/rating/{ratingID}/delete', [RatingController::class, 'destroy'])->name('game.deleteRating');
Route::post('/ratings/{rating}/like', [RatingController::class, 'like'])->name('ratings.like');
Route::get('/game/rating', [GameController::class, 'showRanking'])->name('game.rating');

Route::get('/player-login', [AuthController::class, 'showPlayerLogin'])->name('player.login');
Route::post('/player-login', [AuthController::class, 'playerLogin']);
Route::get('/player-register', [AuthController::class, 'showPlayerRegister'])->name('player.register');
Route::post('/player-register', [AuthController::class, 'playerRegister'])->name('player.register');//zxczcazcsc

Route::get('/staff-login', [AuthController::class, 'showStaffLogin'])->name('staff.login');
Route::post('/staff-login', [AuthController::class, 'staffLogin']);
Route::get('/staff-register', [AuthController::class, 'showStaffRegister'])->name('staff.register');
Route::post('/staff-register', [AuthController::class, 'staffRegister']);

Route::get('/developer-login', [AuthController::class, 'showDeveloperLogin'])->name('developer.login');
Route::post('/developer-login', [AuthController::class, 'developerLogin']);
Route::get('/developer-register', [AuthController::class, 'showDeveloperRegister'])->name('developer.register');
Route::post('/developer-register', [AuthController::class, 'developerRegister']);

// staff CRUD
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}/update', [StaffController::class, 'update'])->name('staff.update');
Route::delete('/staff/{staff}/delete', [StaffController::class, 'delete'])->name('staff.delete');

// gamestore CRUD
Route::get('/game_store', [GameStoreController::class, 'index'])->name('game_store.index');
Route::delete('/game_store/{playerID}/{gameID}', [GameStoreController::class, 'delete'])->name('game_store.delete');

//player homepage
Route::get('/home', [PlayerController::class, 'home'])->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// 登出路由
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');


// game CRUD
Route::get('/game', [GameController::class, 'index'])->name('game.index');
Route::get('/game/create', [GameController::class, 'create'])->name('game.create');
Route::post('/game', [GameController::class, 'store'])->name('game.store');
Route::get('/game/{game}/edit', [GameController::class, 'edit'])->name('game.edit');
Route::put('/game/{game}/update', [GameController::class, 'update'])->name('game.update');
Route::delete('/game/{game}/delete', [GameController::class, 'delete'])->name('game.delete');

// event CRUD
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
Route::post('/event', [EventController::class, 'store'])->name('event.store');
Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
Route::put('/event/{event}/update', [EventController::class, 'update'])->name('event.update');
Route::delete('/event/{event}/delete', [EventController::class, 'delete'])->name('event.delete');

Route::middleware(['auth:developer', IsDeveloper::class])->group(function () {
    Route::get('/developer-home', [DeveloperController::class, 'home'])->name('developer.home');
});

// Player 专属路由
Route::middleware(['auth:player', IsPlayer::class])->group(function () {
    Route::get('/home', [PlayerController::class, 'home'])->name('home');
});

// Staff 专属路由
Route::middleware(['auth:staff', IsStaff::class])->group(function () {
    Route::get('/staff-home', [StaffController::class, 'home'])->name('staff.home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
