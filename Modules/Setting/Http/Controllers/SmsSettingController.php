<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SmsSettingController extends Controller
{
    public function index()
    {
        $title = 'Sparrow SMS API Settings';

        return view('setting::sms-settings',[
            'title' => $title,
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        
        $request->validate([
            'sms_api_token' => 'required',
            'sms_identity' => 'required',
        ]);

        settings()->set([
            'sms_api_token' => $request->sms_api_token,
            'sms_identity' => $request->sms_identity,
        ]);

        return redirect()->back()->with('success', 'Settings has been updated successfully.');
    }
}
