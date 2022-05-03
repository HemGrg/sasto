<?php

namespace Modules\User\Http\Controllers;

use App\Channels\SmsApiChannel;
use Aankhijhyaal\LaraSparrow\SmsMessage;
use App\Mail\AccountActivated;
use App\Mail\CustomerResetPassword;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use App\Models\User;
use App\Password;
use App\Rules\Mobile;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;
use Validator;
use DB;
use Str;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Facades\Socialite;
use Modules\Front\Notifications\SmsMessageNotification;
use Modules\Front\Notifications\UserRegisterNotification;

class UserController extends Controller
{

  public function register(Request $request)
  {
    DB::beginTransaction();
    try {
      $validator = Validator::make($request->all(), [
        'full_name' => 'required|string',
        'phone_num' => ['required', new Mobile],
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'confirm_password' => 'required|min:6|same:password',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
      }
      $name = explode(' ', $request->full_name);
      $username = strtolower($name[0] . rand(10, 1000));
      $formData = $request->except(['password']);
      $data = [
        'publish' => 1,
        'username' => $username,
        'activation_link' => Str::random(63),
        'otp' =>    random_int(100000, 999999),
        'name' => $request->full_name,
        'email' => $request->email,
        'phone_num' => $request->phone_num,
        'password' => bcrypt($request->password)
         ];
      $userExist = User::create($data);

      if ($userExist) {
        $user = User::where('email', $request->email)->first();
      }
      $role = Role::where('name','customer')->first();
      $role_data = [
        'role_id' => $role->id,
        'user_id' => $user->id
      ];
      $role_user = Role_user::create($role_data);
      Mail::to($request->email)->send(new UserCreated($user));
      $user->notify(new UserRegisterNotification($user));
      // Notification::send($user, new SmsApiChannel());
      DB::commit();
      return response()->json([
        "message" => "success",
        'user' => $userExist
      ], 200);
    } catch (\Exception $ex) {
      Log::error('User Register', [
          'status' => '500',
          'message' => serialize($ex->getMessage())
      ]);
      return response()->json([
          'status' => '500',
          'message' => 'Something  went wrong'
      ], 500);
    }
  }

  public function VerifyNewAccount($token, Request $request)
  {
    try {
      $user = User::where(['activation_link' => $token])->first();
      if ($user->activation_link == $token) {
        $data['activation_link'] = null;
        $data['verified']     = 1;
      }
      if($user->verified == 1){
        return response()->json([
          "message" => "Thank You ! Your Account Has already been Activated. You can login your account!!",
        ],200);
      }
      $user->fill($data);
      $success = $user->save();
      if ($success) {
        Mail::to($user->email)->send(new AccountActivated($user));
        return response()->json([
          "message" => "Thank You ! Your Account Has been Activated. You can login your account now",
        ], 200);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function verifificationCode(Request $request)
  {
    try {
      $user = User::where(['otp' => $request->otp])->first();
      if ($user->otp == $request->otp) {
        $data['otp'] = null;
        $data['verified']  = 1;
      }
      if($user->verified == 1){
        return response()->json([
          "message" => "Thank You ! Your Account Has already been Activated. You can login your account!!",
        ],200);
      }
      $user->fill($data);
      $success = $user->save();
      if ($success) {
        Mail::to($user->email)->send(new AccountActivated($user));
        return response()->json([
          "message" => "Thank You ! Your Account Has been Activated. You can login your account now",
        ], 200);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => ['required'],
      'password' => ['required'],
    ]);

    try {
      if(is_numeric($request->email)){
        $user = User::where('phone_num', $request->email)->with('roles')->first();
      }else{
        $user = User::where('email', $request->email)->with('roles')->first();
      }
      if (!$user) {
        return response()->json([
          'message' => 'User not found'
        ], 404);
      }

      // Password do not match
      if (!\Hash::check($request->password, $user->password)) {
        return response()->json([
          "message" => "Invalid Password!!"
        ], 401);
      }

      $roles = [];
      foreach ($user->roles as $role) {
        $slug = $role->slug;
        array_push($roles, $slug);
      }

      // Reject if not a customer
      if (!in_array('customer', $roles)) {
        return response()->json([
          "status" => "false",
          "message" => "You are not authorized.",
        ], 401);
      }

      // Reject if not verified
      if (in_array('customer', $roles) && $user->verified == '0') {
        return response()->json([
          "status" => "false",
          "message" => "You account has not been verified yet. Please contact admin!!"
        ], 401);
      }

      if(is_numeric($request->email)){
        if (Auth::attempt([
          'phone_num' => $request['email'],
          'password' => $request['password'],
        ])) {
  
          $token = auth()->user()->createToken('authToken')->accessToken;
  
          return response()->json([
            "status" => "true",
            "message" => "success",
            'token' => $token,
            'user' => auth()->user()
          ], 200);
        }
      }else{
        if (Auth::attempt([
          'email' => $request['email'],
          'password' => $request['password'],
        ])) {
  
          $token = auth()->user()->createToken('authToken')->accessToken;
  
          return response()->json([
            "status" => "true",
            "message" => "success",
            'token' => $token,
            'user' => auth()->user()
          ], 200);
        }
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 500);
    }
  }

  public function sendEmailLink(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
        exit;
      }
      $details = User::where('email', $request->email)->first();
      if ($details) {
        $randomNumber = Str::random(10);

        $token_withSlash = bcrypt($randomNumber);

        $token = str_replace('/', '', $token_withSlash);
        // saving token and user name
        $savedata = ['email' => $request->email, 'token' => $token, 'created_at' => \Carbon\Carbon::now()->toDateTimeString()];
        Password::insert($savedata);
        $password = Password::where('email', $request->email)->where('token', $token)->latest()->first();
        //sending email link
        $data = ['email' => $request->email, 'token' => $token];
        // Mail::send('email.user-password-reset', $data, function ($message) use ($data) {
        //   $message->to($data['email'])->from(env('MAIL_FROM_ADDRESS'));
        //   $message->subject('password reset link');
        // });
        Mail::to($data['email'])->send(new CustomerResetPassword($password,$details));
        return response()->json([
          "message" => "Email has been sent to your email",
        ], 200);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function updatePassword(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        //   'email' => 'required',
        'password' => 'required|min:6',
        'confirm_password' => 'required|min:6|same:password',

      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
        exit;
      }
      $details = Password::where('token', $request->token)->first();
      $user = User::where('email', $details->email)->first();
      $value = $request->all();
      if ($request->password) {
        $value['password'] = bcrypt($request->password);
      }
      $user->update($value);
      return response()->json([
        "message" => "Password has been changed",
      ], 200);
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }


  public function changePassword(Request $request)
  {
      $request->validate([
        'old_password' => 'required',
        'password' => 'required|min:6',
        'confirm_password' => 'required|min:6|same:password',
      ]);
      $auth_user = auth()->user();
      if (!Hash::check($request->old_password, auth()->user()->password)) {
        return response([
          'message' => 'Password does not match'
        ], 403);
      }
        $user = $auth_user->update(['password' => Hash::make($request->password)]);
        return response()->json([
          "message" => "Password has been changed",
        ], 200);
  }

  //GoogleLogin
  public function redirectToGoogle(){
    return Socialite::driver('google')->redirect();
  }
  
  //Google Callback
  public function handleGoogleCallBack(){
    $user = Socialite::driver('google')->user();
    $this->_registerOrLoginUser($user);

    return redirect()->route('home');
  }

  //FacebookLogin
  public function redirectToFacebook(){
    return Socialite::driver('facebook')->redirect();
  }
  
  //Facebook Callback
  public function handleFacebookCallBack(){
    $user = Socialite::driver('facebook')->user();
  }

  protected function _registerOrLoginUser($data){
    $user = User::where('email',$data->email)->first();
    if(!$user){
      $user = new User();
      $user->name = $data->name;
      $user->email = $data->email;
      $user->password = $data->password;
      $user->api_token = $data->token;
      $user->save();
    }
    Auth::login($user);
  }
}
