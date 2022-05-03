<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SocialiteLoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/fire', function (Request $request) {
    return $request->all();
});


Route::get('/message', [App\Http\Controllers\MessageController::class, 'message']);
// Route::get('/categories', 'CategoryController@index')->name('categories');

 //login with Google
 Route::get('login/google', [SocialiteLoginController::class, 'redirectToGoogle'])->name('login.google');
 Route::get('login/google/callback', [SocialiteLoginController::class, 'handleGoogleCallBack'])->name('social.callback');

 //login with Facebook
 Route::get('login/facebook', [SocialiteLoginController::class, 'redirectToFacebook'])->name('login.facebook');
 Route::get('login/facebook/callback', [SocialiteLoginController::class, 'handleFacebookCallBack']);
