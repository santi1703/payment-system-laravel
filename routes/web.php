<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;

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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/locate', [UserController::class, 'locate'])->name('locate-user');
Route::match(['get', 'post'], '/locate', [UserController::class, 'locate'])->name('locate-user');

Route::get('/teams', [TeamController::class, 'index'])->name('teams');
