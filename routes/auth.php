
<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/login/steam', [AuthController::class, 'redirectToSteam'])->name('login.steam');
Route::get('/login/steam/callback', [AuthController::class, 'handleSteamCallback']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
