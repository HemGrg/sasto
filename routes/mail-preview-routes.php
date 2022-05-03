<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Modules\User\Entities\Vendor;

Route::get('vendor-created-mail', function () {
    // Mail::to('jmsbhatta@gmail.com')->send(new \App\Mail\VendorCreated(Vendor::first()));
    return (new \App\Mail\VendorCreated(\Modules\User\Entities\Vendor::inRandomOrder()->first()))->render();
})->name('vendor-created-mail');

Route::get('user-created-mail', function () {
    // Mail::to('jmsbhatta@gmail.com')->send(new \App\Mail\UserCreated(User::first()));
    return (new \App\Mail\UserCreated(\App\Models\User::inRandomOrder()->first()))->render();
})->name('user-created-mail');
