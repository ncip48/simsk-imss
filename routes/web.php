<?php

use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Signature;
use App\Livewire\SuratKeluar;
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

Route::get('/', function () {
    return redirect()->route('login');
})->name('index');

Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('surat-keluar', function () {
        return view('surat-keluar');
    })->name('surat-keluar');
    Route::get('tanda-tangan', function () {
        return view('tanda-tangan');
    })->name('tanda-tangan');
    Route::get('dokumen', function () {
        return view('dokumen');
    })->name('dokumen');
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('divisi', function () {
            return view('divisi');
        })->name('divisi');
        Route::get('user', function () {
            return view('user');
        })->name('user');
    });
    Route::get('generate-surat', function () {
        return view('generate-surat');
    })->name('generate-surat');

    Route::get('edit-profile', function () {
        return view('edit-profile');
    })->name('edit-profile');

    Route::get('kode-aset', function () {
        return view('kode-aset');
    })->name('kode-aset');
    Route::get('asset', function () {
        return view('asset');
    })->name('asset');
    Route::get('inventaris', function () {
        return view('inventaris');
    })->name('inventaris');

    Route::get('pengaduan', function () {
        return view('pengaduan');
    })->name('pengaduan');

    //LOGOUT
    Route::post('logout', [Login::class, 'logout'])->name('logout');
});

Route::post('test_excel', [SuratKeluar::class, 'importSurat'])->name('test_excel');
Route::get('test_certificate', [Signature::class, 'generateCertificate'])->name('test_certificate');
Route::get('test_signature', [Signature::class, 'generateSignature'])->name('test_signature');
Route::get('test_check', [Signature::class, 'checkSignature'])->name('test_check');
Route::get('drag', function () {
    return view('test');
});
