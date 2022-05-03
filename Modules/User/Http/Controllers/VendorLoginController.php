<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Modules\AlternativeUser\Entities\AlternativeUser;

class VendorLoginController extends Controller
{
    public function loginForm()
    {
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'remember' => 'nullable|boolean',
        ]);

        try {
            $alternativeUser = null;
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $alternativeUser = AlternativeUser::with('user')->where('email', $request->email)->first();
                $user = $alternativeUser->user ?? null;
            }

            if (!$user) {
                return response()->json([
                    "message" => "User Not Found!!"
                ], 401);
            }

            if ($user) {
                if (!\Hash::check($request->password, $alternativeUser ? $alternativeUser->password : $user->password)) {
                    return response()->json([
                        "message" => "Invalid Password!!"
                    ], 401);
                }
            }

            if (!$user->hasRole('vendor')) {
                return response()->json([
                    "message" => "This email does not exist."
                ], 400);
            }

            if ($user->publish == '0') {
                return response()->json([
                    "message" => "Your account has not been approved yet !!"
                ], 400);
            }

            if ($user->verified == 0) {
                session()->flush();
                return response()->json([
                    "status_code" => 401,
                    "message" => "Please Verify your account first!!"
                ], 401);
            }

            Auth::login($user, $request->filled('remember'));
            if ($alternativeUser) {
                session()->put('alt_usr', $alternativeUser);
            }
            $token = auth()->user()->createToken('authToken')->accessToken;
            $user->api_token = $token;
            $user->save();

            if ($user->vendor_type == 'new' || $user->vendor_type == 'suspended') {
                Auth::logout();
                return response()->json([
                    "status_code" => 401,
                    "message" => "Please Verify your account by admin first!!"
                ], 400);
            }

            return response()->json([
                "status_code" => 200,
                "message" => "success",
                'token' => $token,
                'user' => $user
            ], 200);

        } catch (\Exception $exception) {
            report($exception);
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Invalid Username/password"
        ], 500);
    }
    
}
