<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TicketController;
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

// Route::get('/', function () {
//     return view('authentication.login');
// });

//email notif
Route::get('/mail/send', [CustomerController::class, 'index']);

//registration 
Route::get('/customer/forms', [CustomerController::class, 'forms']); 
Route::get('/user/forms', [UserController::class, 'forms']); 
Route::post('/user/register', [UserController::class, 'register']); 
Route::post('/customer/register', [CustomerController::class, 'register']); 

//login
Route::get('/login/user', [LoginController::class, 'showUserLogin'])->name('login.user');
Route::get('/', [LoginController::class, 'showCustomerLogin'])->name('login.customer');
Route::post('/login/user', [LoginController::class, 'userLogin']);
Route::post('/login/customer', [LoginController::class, 'customerLogin'])->name('store.customer');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//route to get users by department for ajax
Route::get('department/users', [UserController::class, 'getUsers'])->name('get.users');

//view dashboard 
Route::middleware('auth:customer')->group(function () {
    Route::get('/dashboard/customer', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
});
Route::middleware('auth:user')->group(function () {
    Route::get('/dashboard/user', [UserController::class, 'dashboard'])->name('user.dashboard');
});

//tickets
Route::resource('tickets', TicketController::class)->only([
    'index', 'create', 'store', 'show', 'update'
]);

//to view attachment
Route::get('/attachments/{id}', [TicketController::class, 'attachment'])->name('show.attachment');

//to add comment
Route::post('/add/comment/{id}', [CommentController::class, 'store'])->name('comment.create'); 




