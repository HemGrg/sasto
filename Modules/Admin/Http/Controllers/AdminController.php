<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Auth,Validator;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminController extends Controller
{
    public function login()
    {
        if(!auth()->check()) {
            return view('admin::login');
        }
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->sendLoginErrorResponse($request);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->sendLoginErrorResponse($request);
        }

        // if ($user->role == 'admin' && $user->publish == 0) {
        //     return back()->with('message', "Your account is inactive! Please contact Team.");
        // }

        $roles = [];
        foreach ($user->roles()->get() as $role) {
            array_push($roles, $role->slug);
        }

        // Return if user is not super_admin or admin or vendor
        if (!in_array('super_admin', $roles, TRUE) && !in_array('admin', $roles, TRUE)) {
            return $this->sendLoginErrorResponse($request);
        }

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $token = auth()->user()->createToken('authToken')->accessToken;
            $profile = Auth::user();
            $profile->api_token = $token;
            $profile->save();
            return redirect()->intended('dashboard');
            // return redirect('/dashboard');
        } else {
            return back()->withErrors(['login' => 'Something went wrong while logging you in.']);
        }
    }

    private function sendLoginErrorResponse(Request $request)
    {
        return $request->wantsJson()
            ? new JsonResponse([
                'error' => 'These credentials do not match our records.',
            ], 404)
            : redirect()->back()->withErrors(['login' => 'These credentials do not match our records.']);
    }

    public function admin__logout()
    {
        if(auth()->user()->hasAnyRole('super_admin|admin') ){
            auth()->user()->tokens()->delete();
            Auth::logout();
            Session::flush();
            return redirect()->route('login');
        } else {
            auth()->user()->tokens()->delete();
            Auth::logout();
            Session::flush();
            return redirect()->to('/vendor-login');
        }
    }
    
    public function changePassword(){
        $detail = auth()->user();
        return view('admin::change-password',compact('detail'));
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:new_password',
          ]);
          if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
          }
        if (Hash::check($request->old_password, auth()->user()->password)) {
            auth()->user()->update(['password' => Hash::make($request->new_password)]);
            return redirect()->back()->with(['message' => 'Password Updated Successfully']);
        } else {
            return redirect()->back()->withErrors(['old_password' => 'Sorry your old password is incorrect']);
        }
    }
}
