<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\MainController;
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

// Step 1
Route::get('/', [MainController::class, 'startSessionForm'])->name('start');
Route::post('/start-session', [MainController::class, 'startSession'])->name('start.session');
// Step 2
Route::view('/introductie', 'introductie')->name('introductie');
// Step 3
Route::view('/instructies', 'instructies')->name('instructies');
// Step 4
Route::get('/video/{id}/{index}', [MainController::class, 'video'])->name('video');
// Step 5
Route::view('/done', 'done')->name('done');

// Reset
Route::get('/reset', [MainController::class, 'resetSession'])->name('reset');

// Data routes
Route::get('/list', DataController::class)->name('data');
Route::get('/view/{file}', [DataController::class, 'view'])->name('view');
Route::get('/replay/{id}/{index}', [MainController::class, 'video'])->name('replay');

// ROI routes
Route::post('/add', [DataController::class, 'add'])->name('add');
Route::post('/remove', [DataController::class, 'remove'])->name('remove');
