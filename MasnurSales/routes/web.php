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
    // Route to view all transactions
    Route::get('/transactions', [ManageTransactionController::class, 'index'])->name('transactions.index');
    
    // Route to show the create form
    Route::get('/transactions/create', [ManageTransactionController::class, 'create'])->name('transactions.create');
    
    // Route to store the new transaction
    Route::post('/transactions', [ManageTransactionController::class, 'store'])->name('transactions.store');
    
    // Route to view monthly sales
    Route::get('/transactions/monthly', [ManageTransactionController::class, 'showMonthlyTransactions'])->name('transactions.monthly');
    
    // Route to show the edit form for a transaction
    Route::get('/transactions/{transaction}/edit', [ManageTransactionController::class, 'edit'])->name('transactions.edit');
    
    // Route to update the transaction
    Route::put('/transactions/{transaction}', [ManageTransactionController::class, 'update'])->name('transactions.update');
    
    // Route to delete a transaction
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});



Route::resource('transactions', ManageTransactionController::class);
