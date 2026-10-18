<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PawFinder Application
|--------------------------------------------------------------------------
*/

// 1. Halaman Utama / Landing Page (Dapat diakses oleh siapa saja)
Route::get('/', function () {
    return view('landing');
});

// 2. Halaman Terproteksi (WAJIB LOGIN)
Route::middleware('auth')->group(function () {
    // Halaman Peta Interaktif Fasilitas Balikpapan
    Route::get('/map', function () {
        return view('map');
    });

    // Fitur Chat AI Paw Assistant
    Route::get('/chat', [ChatController::class, 'index']);
    Route::post('/chat', [ChatController::class, 'sendMessage']);
});

// 3. Modul Autentikasi User
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);