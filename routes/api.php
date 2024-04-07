<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/email/verify', [AuthController::class , 'emailVerify'])->name('email.verify');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('taskList' , TaskListController::class);
});

//1234maH@
