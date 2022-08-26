<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PublicController;
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


Route::get('/', [PublicController::class, 'index'])->name('index');
Route::get('/details', [PublicController::class, 'details'])->name('details');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('dashboard');
    Route::post('/store', [EventController::class, 'store'])->name('event.store');
    Route::get('/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::post('/update', [EventController::class, 'update'])->name('event.update');
    Route::get('/delete/{id}', [EventController::class, 'delete'])->name('event.delete');
});

Route::prefix('invitation')->group(function () {
    Route::get('/{id}', [InvitationController::class, 'index'])->name('invite.index');
    Route::post('/store', [InvitationController::class, 'store'])->name('invite.store');
    Route::get('/delete/{id}', [InvitationController::class, 'delete'])->name('invite.delete');
    Route::post('/check', [InvitationController::class, 'check'])->name('invite.check');
});


    

