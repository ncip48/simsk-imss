<?php

use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\User;
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

Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('surat-keluar', function () {
        return view('surat-keluar');
    })->name('surat-keluar');
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('divisi', function () {
            return view('divisi');
        })->name('divisi');
        Route::get('user', function () {
            return view('user');
        })->name('user');
    });

    //LOGOUT
    Route::post('logout', [Login::class, 'logout'])->name('logout');
});
