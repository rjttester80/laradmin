<?php

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

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

Route::get('/user-register', [UserController::class, 'loadRegister'])->name('register');
Route::post('/user-register', [UserController::class, 'userRegister'])->name('userRegister');

Route::get('/user-login', [UserController::class, 'loadLogin'])->name('login');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('userLogin');

Route::get('/forgot-password', [UserController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/forget-password', [UserController::class, 'forgetPassword'])->name('forgetPassword');

Route::get('/reset-password', [UserController::class, 'resetPasswordLoad']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');

Route::get('/contact-us', [UserController::class, 'contact'])->name('contact');

Route::get('/logout', [UserController::class, 'logout']);

Route::get('/auth/google', [UserController::class, 'loginGoogle'])->name('loginGoogle');
Route::any('/auth/google/callback', [UserController::class, 'gloginCallback'])->name('glogin');

Route::get('/auth/github', [UserController::class, 'loginGithub'])->name('loginGithub');
Route::any('/auth/callback', [UserController::class, 'githubCallback']);


//Route::get('/register', [AuthController::class, 'loadRegister']);
//Route::post('/register', [AuthController::class, 'userRegister'])->name('userRegister');

/* Route::get('/login', function () {
    return redirect('/');
}); */

Route::get('/admin-login', [AuthController::class, 'loadAdminLogin'])->name('loadAdminLogin');
Route::post('/admin-login', [AuthController::class, 'adminLogin'])->name('adminLogin');

Route::get('/logout', [AuthController::class, 'logout']);

Route::group(['middleware'=>['web', 'checkAdmin']], function(){

    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard']);
    Route::get('/admin/users', [AdminController::class, 'usersDashboard'])->name('usersDashboard');
    Route::get('/user-created', [AdminController::class, 'usersCreated'])->name('usersCreated');
    Route::get('/trashed', [AdminController::class, 'trashed'])->name('trashed');
    Route::post('/add-user', [AdminController::class, 'addUser'])->name('addUser');
    Route::post('/edit-user', [AdminController::class, 'editUser'])->name('editUser');
    Route::post('/trash-user', [AdminController::class, 'trashUser'])->name('trashUser');
    Route::post('/del-user', [AdminController::class, 'deleteUser'])->name('deleteUser');
    Route::get('/restore-user', [AdminController::class, 'restoreUser'])->name('restoreUser');
    Route::get('/show-chart', [AdminController::class, 'showChart'])->name('showChart');
    Route::get('/change-status', [AdminController::class, 'changeStatus'])->name('changeStatus');
    Route::get('/month-data', [AdminController::class, 'monthData'])->name('monthData');
    //Route::get('ajax-crud-datatable', [AdminController::class, 'index']);

});

Route::group(['middleware'=>['web', 'checkUser']], function(){

    Route::get('/dashboard', [AuthController::class, 'loadDashboard'])->name('dashboard');
    Route::get('/users-posts', [PostController::class, 'postsDashboard'])->name('postsDashboard');
    Route::get('/post-categories', [CategoryController::class, 'postCategories'])->name('postCategories');
    Route::post('/add-category', [CategoryController::class, 'addCategory'])->name('addCategory');
    Route::post('/edit-category', [CategoryController::class, 'editCategory'])->name('editCategory');


});


