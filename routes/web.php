<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/surat-masuk/detail', function () {
    return redirect()->route('incoming.mail.list');
});
Route::get('/surat-keluar/detail', function () {
    return redirect()->route('incoming.outmail.list');
});
Route::controller(SuratMasukController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/surat-masuk', 'index')->name('incoming.mail.list');
    Route::get('/surat-masuk/tambah', 'add')->name('add.mail.list');
    Route::post('/surat-masuk/tambah', 'store')->name('store.mail.list');
    Route::post('/surat-masuk/upload', 'uploadCsv')->name('store.mail.upload');
    Route::get('/sample-csv-surat-masuk', 'downloadCsvSample')->name('sample.csv.mail');

    Route::get('/surat-masuk/detail/{id}', 'detail')->name('detail.mail.list')->middleware("signed");
    Route::post('/surat-masuk/detail', 'edit')->name('edit.mail.list');
    Route::delete('/surat-masuk/hapus/{id}', 'delete')->name('delete.mail.list');
});

Route::controller(SuratKeluarController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/surat-keluar', 'index')->name('incoming.outmail.list');
    Route::get('/sample-csv-surat-keluar', 'downloadCsvSample')->name('sample.csv.outmail');
    Route::get('/surat-keluar/tambah', 'add')->name('add.outmail.list');
    Route::post('/surat-keluar/tambah', 'store')->name('store.outmail.list');
    Route::post('/surat-keluar/upload', 'uploadCsv')->name('store.outmail.upload');
    Route::get('/surat-keluar/detail/{id}', 'detail')->name('detail.outmail.list')->middleware("signed");
    Route::post('/surat-keluar/detail', 'edit')->name('edit.outmail.list');
    Route::delete('/surat-keluar/hapus/{id}', 'delete')->name('delete.outmail.list');
});

Route::controller(SearchController::class)->group(function () {
    Route::get('/', 'index')->name('search');
});
Route::controller(UserController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/user', 'index')->name('user.management');
    Route::get('/user-add', 'add')->name('user.management.add');
    Route::post('/user', 'store')->name('user.management.post');
});


require __DIR__ . '/auth.php';
