<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
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


//login
Route::get('/', [LoginController::class, 'index'])->name('login.user');
Route::post('/login/user', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('checkRole:1,2,3');

//ajax routes 
//route to get users by department
Route::get('department/users', [UserController::class, 'getUsers'])->name('get.users')->middleware('checkRole:1,2,3');
//route to get departments by company
Route::get('company/departments', [UserController::class, 'getDepartments'])->name('get.departments')->middleware('checkRole:1');

//view dashboard 
Route::get('/dashboard/user', [UserController::class, 'dashboard'])->name('user.dashboard')->middleware('checkRole:1,2,3');

//user controller
Route::middleware('checkRole:1')->group(function () {
    Route::resource('users', UserController::class)->only([
        'index', 'store', 'update'
    ]);
});

//tickets
Route::resource('tickets', TicketController::class)->only([
    'index', 'create', 'store', 'show', 'update'
]);

//to view attachment
Route::get('/attachments/{id}', [TicketController::class, 'attachment'])->name('show.attachment')->middleware('checkRole:1,2,3');

//to view assigned tickets
Route::get('assigned/tickets', [TicketController::class, 'assigned'])->name('tickets.assigned')->middleware('checkRole:1,2'); 

//to add comment
Route::post('/add/comment/{id}', [CommentController::class, 'store'])->name('comment.create')->middleware('checkRole:1,2,3'); 

//article controller
Route::resource('articles', ArticleController::class)->only([
    'index', 'store', 'show', 'update'
]);

Route::middleware('checkRole:1,2,3')->group(function () {
    //view profile
    Route::get('/view/profile', [ProfileController::class, 'index'])->name('view.profile');
    //edit profile
    Route::put('/update/profile', [ProfileController::class, 'update'])->name('update.profile');
});

Route::middleware('checkRole:1')->group(function () {
    Route::resource('departments', DepartmentController::class)->only([
        'create', 'show', 'store', 'update'
    ]);
});

Route::middleware('checkRole:1')->group(function () {
    Route::resource('companies', CompanyController::class)->only([
        'store', 'update'
   ]);
});

//view email input page
Route::get('/reset/password', [PasswordController::class, 'reset'])->name('view.reset');
//send email link and push data in db
Route::post('/send/email',[PasswordController::class, 'sendEmail'])->name('send.email');
//view reset password page
Route::get('/reset/password/{token}', [PasswordController::class, 'resetPassword'])->name('reset.link'); 
// reset password user
Route::put('/user/password', [PasswordController::class, 'resetUserPassword'])->middleware('checkRole:1,2,3');


