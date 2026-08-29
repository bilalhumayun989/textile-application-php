<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlendRatioController;
use App\Http\Controllers\CoverFactorController;
use App\Http\Controllers\CostingController;
use App\Http\Controllers\TowlCost1Controller;
use App\Http\Controllers\TowlCost2Controller;
use App\Http\Controllers\RunBalanceController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\WalletNetController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes (Commented as requested)
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Protected Application Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', [BlendRatioController::class, 'index'])->name('blend.index');
    Route::post('/', [BlendRatioController::class, 'store'])->name('blend.store');

    // cover factor calculator
    Route::get('/factorcover', [CoverFactorController::class, 'index'])->name('factor.index');
    Route::post('/factorcover', [CoverFactorController::class, 'store'])->name('factor.store');

    // costing calculator
    Route::get('/costing', [CostingController::class, 'index'])->name('costing.index');
    Route::post('/costing', [CostingController::class, 'store'])->name('costing.store');

    // running balance / ledger
    Route::get('/run_balance', [RunBalanceController::class, 'index'])->name('run_balance.index');
    Route::post('/run_balance', [RunBalanceController::class, 'store'])->name('run_balance.store');

    // customer management
    Route::get('/run_balance/customer/create', [RunBalanceController::class, 'showCustomerForm'])
        ->name('run_balance.customer_create');
    Route::post('/run_balance/customer', [RunBalanceController::class, 'storeCustomer'])
        ->name('run_balance.add_customer');
    Route::delete('/run_balance/customer', [RunBalanceController::class, 'destroyCustomer'])
        ->name('run_balance.delete_customer');
    Route::delete('/run_balance/transactions/{transaction}', [RunBalanceController::class, 'destroyTransaction'])
        ->name('run_balance.transactions.destroy');

    // wallet module
    Route::get('wallets/{wallet}/expenses', [WalletController::class, 'expenses'])->name('wallets.expenses');

    // Bank routes
    Route::get('/banks', [BankController::class, 'index'])->name('banks.index');
    Route::put('/banks/{bank}', [BankController::class, 'update'])->name('banks.update');

    Route::get('/wallets', [WalletController::class, 'index'])->name('wallets.index');
    Route::get('/wallets/create', [WalletController::class, 'create'])->name('wallets.create');
    Route::post('/wallets', [WalletController::class, 'store'])->name('wallets.store');

    // net calculation
    Route::get('/wallets/net', [WalletNetController::class, 'index'])->name('wallets.net');
    Route::post('/wallets/net', [WalletNetController::class, 'store'])->name('wallets.net.store');
    Route::delete('/wallets/net/{net}', [WalletNetController::class, 'destroy'])->name('wallets.net.destroy');

    // wallet detail and entry routes
    Route::get('/wallets/{wallet}', [WalletController::class, 'show'])
        ->where('wallet', '[0-9]+')
        ->name('wallets.show');
    Route::post('/wallets/{wallet}/entry', [WalletController::class, 'storeEntry'])
        ->where('wallet', '[0-9]+')
        ->name('wallets.entry');
    Route::delete('/wallets/{wallet}', [WalletController::class, 'destroy'])
        ->where('wallet', '[0-9]+')
        ->name('wallets.destroy');
    Route::delete('/wallets/entry/{entry}', [WalletController::class, 'destroyEntry'])->name('wallets.entry.destroy');

    Route::view('/home', 'home')->name('home');

});

