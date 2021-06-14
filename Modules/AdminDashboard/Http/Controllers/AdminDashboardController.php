<?php

namespace Modules\AdminDashboard\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{


    public function dashboard(){
       
        return view('admindashboard::dashboard');
    }
    
    public function login(){
        return view('admindashboard::admin_login');
    }
     
    public function init(){
        $user = Auth::user();
        return ['user' => $user];
    }

    public function postLogin(Request $request){
        if(Auth::attempt(['email' => $request['userName'], 'password' => $request['password']])){
            $user = Auth::user();
            return ['user' => $user];
        }else{
            return response()->json([
                "error" => "Could not log you in", 483
            ]);
        }
    }

    public function register(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        Auth::login($user);
        return ["user" => $user];
    }

}
