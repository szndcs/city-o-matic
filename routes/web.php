<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\AjaxRequest\AjaxRequestController;


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

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/getcities/{county}', [AjaxRequestController::class, 'getcities']);
Route::post('/city', [AjaxRequestController::class, 'addcity']);
Route::put('/city', [AjaxRequestController::class, 'updatecity']);
Route::delete('/city', [AjaxRequestController::class, 'deletecity']);
