<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\SocialiteLoginController;
use Illuminate\Support\Facades\Artisan;
use Pusher\Pusher;
use Illuminate\Http\Request;
use Modules\Country\Entities\Country;
use Modules\Faq\Entities\Faq;
use Modules\User\Http\Controllers\UserController;

// Vendor Routes

Route::redirect('/', '/vendor-homepage')->name('home');
Route::view('/vendor-login', 'vendor_login')->middleware('guest');

Route::get('/vendor-register', function () {
    $countries = Country::select('id', 'name')->get();
    return view('register')->with(compact('countries'));
});

Route::view('/forgot-password', 'forgotpassword');

Route::get('/password-resetform/{token}', function ($token) {
    $token = $token;
    return view('reset_password')->with(compact('token'));
});

Route::view('/account-verification', 'account_verification');

Route::view('/vendor-homepage', 'vendor_homepage');

Route::get('system-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/faq', function () {
    $faqs = Faq::published()->get();
    return view('faq')->with(compact('faqs'));
});

Route::view('/about-us', 'footer_pages.about_us');

Route::view('/terms-conditions', 'footer_pages.terms_condition');

Route::view('/terms-of-use', 'footer_pages.terms_of_use');

Route::view('/privacy-policy', 'footer_pages.privacy_policy');
Route::view('/logistics-management', 'footer_pages.logistics_management');

// End of Vendor Routes


Route::group([], function () {
    // Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
    // Route::post('postLogin', [LoginController::class, 'postLogin'])->name('admin.postLogin');
    Route::get('password-reset', [PasswordResetController::class, 'resetForm'])->name('password-reset');
    Route::post('send-email-link', [PasswordResetController::class, 'sendEmailLink'])->name('sendEmailLink');
    // Route::get('reset-password/{token}', [PasswordResetController::class, 'passwordResetForm'])->name('passwordResetForm');
    Route::post('update-password', [PasswordResetController::class, 'updatePassword'])->name('updatePassword');
});


// Route::get('/payment-test', [App\Http\Controllers\TestController::class, 'payment']);

Route::post('/pusher/auth', function (Request $request) {
    $pusher_id = "1283512";
    $pusher_app_key = "cbe0b7b8904e2ede8292";
    $pusher_app_secret = "e934d010ddd74158d0ba";
    $pusher = new Pusher($pusher_app_key, $pusher_app_secret, $pusher_id);
    $auth = $pusher->socketAuth($request->channel_name, $request->socket_id);
    // $auth = str_replace('\\', '', $auth);
    // header('Content-Type: application/javascript');
    // echo ($callback . '(' . $auth . ');');
    // return;
    // $authString = hash_hmac("sha256", $signature_string, $pusher_app_secret);
    return $auth;
})->middleware('auth');


// Sentry test route
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

    //login with Google
    Route::get('login/google', [SocialiteLoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('login/google/callback', [SocialiteLoginController::class, 'handleGoogleCallBack'])->name('social.callback');

    //login with Facebook
    Route::get('login/facebook', [SocialiteLoginController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('login/facebook/callback', [SocialiteLoginController::class, 'handleFacebookCallBack']);


