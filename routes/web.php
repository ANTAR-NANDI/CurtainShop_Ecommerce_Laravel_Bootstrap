<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\RegistrationController;
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
//     return view('welcome');
// });
// Global Section for All Kind of Users
//Home Section
Route::get('/', [FrontendController::class, 'index'])->name('/');
//Shop Section
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
//Blog Section
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
//Contact Section
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
//About Us Section
Route::get('/about', [FrontendController::class, 'about'])->name('about');
//Registration Section
Route::get('/signup', [RegistrationController::class, 'index'])->name('signup');
Route::post('signup', [RegistrationController::class, 'signupSubmit'])->name('signup.submit');
//Login Section
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'loginSubmit'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
