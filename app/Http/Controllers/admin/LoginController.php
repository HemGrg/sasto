<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Role\Entities\Role;
use Modules\Role\Entities\Role_user;
use Session;
use DB;


class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        // dd($user);
        $roles = [];

        foreach ($user->roles()->get() as $role) {
            array_push($roles, $role->slug);
        }
        // dd($roles);
        if (!$user) {
            return back()->with('message', 'User not found');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('message', 'Invalid Username\Password');
        }

        // if ($user->role == 'admin' && $user->publish == 0) {
        //     return back()->with('message', "Your account is inactive! Please contact Team.");
        // }

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user_login_token= auth()->user()->createToken('PassportExample@Section.io')->accessToken;

            if (in_array('super_admin', $roles, TRUE) || in_array('admin', $roles, TRUE)) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('admin.logout');
            }
        } else {
            return back()->withInput()->withErrors(['email' => 'something is wrong!']);
        }
    }
    public function admin__logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('admin.login');
    }
}
