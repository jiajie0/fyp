<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameStoreController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsPlayer;
use App\Http\Middleware\IsDeveloper;
use App\Http\Middleware\IsStaff;







// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [GameController::class, 'showWelcomePage'])->name('welcome');
Route::get('/game/{game}/detail', [GameController::class, 'showGameDetails'])->name('game.detail');
Route::post('/game/{gameID}/add-to-store', [GameStoreController::class, 'addToGameStore'])->name('game.addToStore');
Route::post('/game/{gameID}/rate', [RatingController::class, 'store'])->name('game.rate');
Route::get('/rating/{ratingID}/edit', [RatingController::class, 'edit'])->name('game.editRating');
Route::put('/rating/{ratingID}/update', [RatingController::class, 'update'])->name('game.updateRating');
Route::delete('/rating/{ratingID}/delete', [RatingController::class, 'destroy'])->name('game.deleteRating');

Route::get('/player-login', [AuthController::class, 'showPlayerLogin'])->name('player.login');
Route::get('/staff-login', [AuthController::class, 'showStaffLogin'])->name('staff.login');
Route::get('/developer-login', [AuthController::class, 'showDeveloperLogin'])->name('developer.login');

Route::get('/player-register', [AuthController::class, 'showPlayerRegister'])->name('player.register');
Route::get('/staff-register', [AuthController::class, 'showStaffRegister'])->name('staff.register');
Route::get('/developer-register', [AuthController::class, 'showDeveloperRegister'])->name('developer.register');

Route::post('/player-login', [AuthController::class, 'playerLogin']);
Route::post('/staff-login', [AuthController::class, 'staffLogin']);
Route::post('/developer-login', [AuthController::class, 'developerLogin']);

Route::post('/player-register', [AuthController::class, 'playerRegister'])->name('player.register');//zxczcazcsc
Route::post('/staff-register', [AuthController::class, 'staffRegister']);
Route::post('/developer-register', [AuthController::class, 'developerRegister']);

// staff CRUD
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}/update', [StaffController::class, 'update'])->name('staff.update');
Route::delete('/staff/{staff}/delete', [StaffController::class, 'delete'])->name('staff.delete');

// game CRUD
Route::get('/game', [GameController::class, 'index'])->name('game.index');
Route::get('/game/create', [GameController::class, 'create'])->name('game.create');
Route::post('/game', [GameController::class, 'store'])->name('game.store');
Route::get('/game/{game}/edit', [GameController::class, 'edit'])->name('game.edit');
Route::put('/game/{game}/update', [GameController::class, 'update'])->name('game.update');
Route::delete('/game/{game}/delete', [GameController::class, 'delete'])->name('game.delete');

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


// Developer 专属路由
Route::middleware(['auth:developer', IsDeveloper::class])->group(function () {
    Route::get('/developer-home', [DeveloperController::class, 'home'])->name('developer.home');
});

Route::middleware(['auth:player', IsPlayer::class])->group(function () {
    Route::get('/home', [PlayerController::class, 'home'])->name('home');
});


// Player 专属路由
Route::middleware(['auth', 'isPlayer'])->group(function () {
    Route::get('/player-home', [PlayerController::class, 'home'])->name('player.home');
});

// Staff 专属路由
Route::middleware(['auth', 'isStaff'])->group(function () {
    Route::get('/staff-home', [StaffController::class, 'home'])->name('staff.home');
});

Route::middleware('auth')->group(function () { //route放进这里，user必须login才能访问
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
