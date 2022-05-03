<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;
use Modules\Setting\Notifications\TestNotification;

class NotificationSettingController extends Controller
{
    public function index()
    {
        $title = "Test Notifications";
        return view('setting::test-notifications', compact('title'));
    }

    public function sendTestNotification(Request $request)
    {
        if ($request->test_notification_sms_number) {
            Notification::route('smsapi', $request->test_notification_sms_number)
                ->notify(new TestNotification());
        }

        if ($request->test_notification_email) {
            Notification::route('mail', $request->test_notification_email)
                ->notify(new TestNotification());
        }

        return redirect()->back()->with('success', 'Test notification has been sent.');
    }
}
