<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('authentication.login');
});

//email notif
Route::get('/mail/send', [CustomerController::class, 'index']);

//post data to database
Route::post('/customer/register', [CustomerController::class, 'register']); 

//post data to database
Route::post('/user/register', [UserController::class, 'register']); 

//login as superuser/customer/user
Route::post('/process', [UserController::class, 'process']); 
Route::post('/process', [CustomerController::class, 'process']); 

//get both forms
Route::get('/customer/forms', [CustomerController::class, 'forms']); 
Route::get('/user/forms', [UserController::class, 'forms']); 

//view dashboard 
Route::get('/dashboard/customer', [CustomerController::class, 'dashboard']); 
Route::get('/dashboard/user', [UserController::class, 'dashboard']); 

