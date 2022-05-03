<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Modules\Role\Entities\Role_user;
use Mail;
use App\Mail\UserRegisteredFromSocial;
use DB;


class SocialiteLoginController extends Controller
{

    //Google Login
    CONST GOOGLE_TYPE = 'google';

    public function redirectToGoogle(){
        $url = Socialite::with(static::GOOGLE_TYPE)->with(["prompt" => "select_account"])->redirect()->getTargetUrl();
        return response()->json([
            "url"=>$url
        ]);
    }

    public function handleGoogleCallBack(){
        try{
            $user = Socialite::driver(static::GOOGLE_TYPE)->stateless()->user();

            $userExisted = User::where('email',$user->email)->first();

            if($userExisted){

                Auth::login($userExisted);
                $token = auth()->user()->createToken('authToken')->accessToken;
                return response()->json([
                    "status" => "true",
                    "message" => "success",
                    'token' => $token,
                    'user' => auth()->user()
                  ], 200);

            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => static::GOOGLE_TYPE,
                    'password' => Hash::make($user->id),
                    'avatar' => $user->getAvatar(),
                    'publish' => 1,
                    'verified' => 1,
                    'vendor_type' => 'approved'
                ]);

                if($newUser){
                    $customer = User::where('email', $user->email)->first();
                }

                $role_data = [
                    'role_id' => 4,
                    'user_id' => $customer->id
                ];
                Role_user::create($role_data);

                Mail::to($customer->email)->send(new UserRegisteredFromSocial($customer));

                Auth::login($newUser);
                
                $token = auth()->user()->createToken('authToken')->accessToken;
                return response()->json([
                    "status" => "true",
                    "message" => "success",
                    'token' => $token,
                    'user' => auth()->user()
                  ], 200);
            }
        }catch(Exception $e){
            dd($e);
        }
    }

    //Facebook login

    CONST FACEBOOK_TYPE = 'facebook';

    public function redirectToFacebook(){
        $url = Socialite::driver(static::FACEBOOK_TYPE)->with(["prompt" => "select_account"])->redirect()->getTargetUrl();
       return response()->json([
        "url"=>$url
    ]);
    }

    public function handleFacebookCallBack(){
        try{
            $user = Socialite::driver(static::FACEBOOK_TYPE)->stateless()->user();
            if(!empty($user->getEmail())){
                $userExisted = User::where('email',$user->email)->first();
                if($userExisted){
                    Auth::login($userExisted);
                    $token = auth()->user()->createToken('authToken')->accessToken;
                    return response()->json([
                        "status" => "true",
                        "message" => "success",
                        'token' => $token,
                        'user' => auth()->user()
                      ], 200);
    
                }else{
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'oauth_id' => $user->id,
                        'oauth_type' => static::FACEBOOK_TYPE,
                        'password' => Hash::make($user->id),
                        'avatar' => $user->getAvatar(),
                        'publish' => 1,
                        'verified' => 1,
                        'vendor_type' => 'approved'
                    ]);
    
                    if($newUser){
                        $customer = User::where('email', $user->email)->first();
                    }
    
                    $role_data = [
                        'role_id' => 4,
                        'user_id' => $customer->id
                    ];
                    Role_user::create($role_data);
    
                    Mail::to($customer->email)->send(new UserRegisteredFromSocial($customer));
    
                    Auth::login($newUser);
                    
                    $token = auth()->user()->createToken('authToken')->accessToken;
                    return response()->json([
                        "status" => "true",
                        "message" => "success",
                        'token' => $token,
                        'user' => auth()->user()
                      ], 200);
                }
            }else{
                return response()->json([
                    "status" => "false",
                    "message" => "unsuccess",
                  ], 402);
            }
           
        }catch(Exception $e){
            DB::rollback();
            return response([
                'message' => $e->getMessage()
            ],400);
        }
    }

    protected function deleteMainUserImage(User $user)
    {
        if ($user->image) {
            $this->imageService->unlinkImage($user->image);
        }
    }
}
