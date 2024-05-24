<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    //return view('welcome');

    //$resEncrypt = encrypt('Password123', true);
    //dd($resEncrypt);
    // eyJpdiI6IkR6WGhrV205bTVnMGFyakd2ZEhEenc9PSIsInZhbHVlIjoieU9VYys3YWdGeEdML0NBRWxXN0ZTZUZ4cDFYVUxxdGJDUHpOeDFoSmVzaz0iLCJtYWMiOiJlOWVhMzY2MTgyNmViYTk2MTBiYWQ3Zjc1NDExMDZmMWU2MjM5ZTVjYjM5MzA2MWUwZDIyNmNiMmNkZjA4ODE3IiwidGFnIjoiIn0=
    //$resDecrypt = decrypt('eyJpdiI6IkR6WGhrV205bTVnMGFyakd2ZEhEenc9PSIsInZhbHVlIjoieU9VYys3YWdGeEdML0NBRWxXN0ZTZUZ4cDFYVUxxdGJDUHpOeDFoSmVzaz0iLCJtYWMiOiJlOWVhMzY2MTgyNmViYTk2MTBiYWQ3Zjc1NDExMDZmMWU2MjM5ZTVjYjM5MzA2MWUwZDIyNmNiMmNkZjA4ODE3IiwidGFnIjoiIn0=', true);
    //dd($resDecrypt);

    $pass = 'Password123';
    $hashPass = Hash::make('Password1234');
    dd(Hash::check($pass, $hashPass));
});

// Auth
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-user', [UserController::class, 'registerUser'])->name('register_user');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginUser'])->name('login_user');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard')->middleware(['authenticate', 'role:superadmin|user']);

Route::get('/login/google', [UserController::class, 'loginGoogle'])->name('login_google');
Route::get('/login/google/callback', [UserController::class, 'loginGoogleCallback'])->name('callback_google');

// product
Route::get('/products', [ProductController::class, 'getProduct'])->name('products.index');

// Dashboard
Route::prefix('dashboard')->middleware('authentication')->group(function () {

    // Products
    Route::prefix('products')->middleware('role:superadmin|user')->group(function () {
        Route::get('/', [DashboardController::class, 'products'])->name('dashboard.products');
        Route::get('/add', [DashboardController::class, 'addProduct'])->name('dashboard.products.add');
        Route::post('/store', [DashboardController::class, 'storeProduct'])->name('dashboard.products.store');
        Route::get('/edit/{id}', [DashboardController::class, 'editProduct'])->name('dashboard.products.edit');
        Route::put('/update/{id}', [DashboardController::class, 'updateProduct'])->name('dashboard.products.update');
        Route::post('/delete/{id}', [DashboardController::class, 'deleteProduct'])->name('dashboard.products.delete');
        Route::get('/export', [DashboardController::class, 'exportProduct'])->name('dashboard.products.export');
    });

    // Users
    Route::prefix('users')->middleware('role:superadmin')->group(function () {
        Route::get('/', [DashboardController::class, 'users'])->name('dashboard.users');
        Route::get('/add', [DashboardController::class, 'addUser'])->name('dashboard.users.add');
        Route::post('/store', [DashboardController::class, 'storeUser'])->name('dashboard.users.store');
        Route::get('/edit/{id}', [DashboardController::class, 'editUser'])->name('dashboard.users.edit');
        Route::put('/update/{id}', [DashboardController::class, 'updateUser'])->name('dashboard.users.update');
        Route::post('/delete/{id}', [DashboardController::class, 'deleteUser'])->name('dashboard.users.delete');
    });

});