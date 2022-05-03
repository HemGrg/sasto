<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Payment\Emails\PaymentRequestMail;

class PaymentRequestController extends Controller
{
    public function requestPayment()
    {
        $vendor = auth()->user()->vendor;

        Mail::to('finance@sastowholesale.com')->send(new PaymentRequestMail($vendor));

        if (auth()->user()->hasRole('vendor')) {
            foreach(admin_users() as $admin) {
                $admin->notify(new \Modules\Payment\Notifications\PaymentRequestNotification($vendor));
            }
        }

        return response()->json([
            'status' => 'success',
        ], 200);
    }
}
