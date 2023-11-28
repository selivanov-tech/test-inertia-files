<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['splade'])->group(function () {
    Route::get('/', fn() => view('home'))->name('home');

    Route::group(['prefix' => 'files'], function () {
        Route::get('/', [FileController::class, 'index'])->name('files.index');
        Route::get('/create', [FileController::class, 'create'])->name('files.create');
        Route::post('/store', [FileController::class, 'store'])->name('files.store');
        Route::get('/edit/{file}', [FileController::class, 'edit'])->name('files.edit');
        Route::get('/download/{file}', [FileController::class, 'download'])->name('files.download');
        Route::post('/update/{file}', [FileController::class, 'update'])->name('files.update');
        Route::delete('/destroy/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    });

    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();
});
