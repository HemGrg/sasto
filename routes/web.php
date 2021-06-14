<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/',[IndexController::class,'index']);

// Route::any('{slug}', function(){
//     return view('welcome');
// });


















//index
// Route::match(['get','post'],'/',[App\Http\Controllers\HomeController::class,'index']);
// //login page
// Route::match(['get','post'],'/admin',[AdminController::class,'login']);
//Route::get('add-service',[ServiceController::class,'store']);
//Route::get('view-service',[ServiceController::class,'index']);
// Route::get('/logout',[AdminController::class,'logout']);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
