<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageProfileController;
use App\Http\Controllers\ManageSystemVariableController;
use App\Http\Controllers\MakeSubscriptionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Http; // Import the Http class
use App\Http\Controllers\ManageTransactionController;
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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [ManageTransactionController::class, 'index'])->name('transactions.index');
    Route::post('/createTransaction', [ManageTransactionController::class, 'createTransaction'])->name('createTransaction');
});


Route::resource('transactions', ManageTransactionController::class);
