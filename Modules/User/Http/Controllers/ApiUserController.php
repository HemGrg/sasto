<?php

namespace Modules\User\Http\Controllers;

use App\Mail\AccountActivated;
use App\Mail\PasswordReset;
use App\Mail\VendorAccountActivated;
use App\Mail\VendorCreated;
use App\Mail\VendorResetPassword;
use App\Mail\VendorStatusChanged;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use App\Models\User;
use App\Password;
use Modules\User\Entities\Vendor;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;
use Modules\Product\Entities\Product;
use Modules\Order\Entities\OrderList;
use Modules\User\Entities\VendorPayment;
use Image;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Str;
use Mail;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{

  public function changeVendorStatus(Request $request)
  {
    $data = $request->all();
    $validation = Validator::make($data, [
      'vendor_id'      => 'required|numeric|exists:users,id',
      'vendor_type'          => 'required',
    ]);
    if ($validation->fails()) {
      foreach ($validation->messages()->getMessages() as $message) {
        $errors[] = $message;
      }
      return response()->json(['status' => false, 'message' => $errors]);
    }
    $user = User::find($request->vendor_id);
    if (!$user) {
      return response()->json(['status' => false, 'message' => ['Invalid vendor id or vendor not found.']]);
    }
    $user->update($data);
    $success = $user->save();
    Mail::to($user->email)->send(new VendorStatusChanged($user));
    return response()->json(['status' => true, 'message' => "Vendor updated Successfully.", 'data' => $user]);
  }

  public function getVendorStatus(Request $request)
  {
    $data = $request->all();
    $validation = Validator::make($data, [
      'vendor_id'      => 'required|numeric|exists:users,id',
      // 'vendor_type'          => 'required',
    ]);
    if ($validation->fails()) {
      foreach ($validation->messages()->getMessages() as $message) {
        $errors[] = $message;
      }
      return response()->json(['status' => false, 'message' => $errors]);
    }
    $user = User::find($request->vendor_id);
    if (!$user) {
      return response()->json(['status' => false, 'message' => ['Invalid vendor id or vendor not found.']]);
    }
    // dd($user);
    // $user->update($data);
    // $success = $user->save();
    // Mail::to($user->email)->send(new VendorStatusChanged($user));
    return response()->json(['status' => true, 'message' => "Vendor status retrieved Successfully.", 'data' => $user]);
  }

  public function VerifyNewAccount($link, Request $request)
  {
    try {
      $user = User::where(['activation_link' => $link])->first();
      if ($user->activation_link == $link) {
        $data['activation_link'] = null;
        $data['verified']     = 1;
      }
      if ($user->verified == 1) {
        return response()->json([
          "message" => "Thank You ! Your Account Has already been Activated. You can login your account",
        ], 200);
      }
      $user->fill($data);
      $success = $user->save();
      if ($success) {
        Mail::to($user->email)->send(new VendorAccountActivated($user));
        return view('email-verified');
        // return redirect()->to('/vendor-login');
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
        $data['verified']     = 1;
      }
      if ($user->verified == 1) {
        return response()->json([
          "message" => "Thank You ! Your Account Has already been Activated. You can login your account!!",
        ], 200);
      }
      $user->fill($data);
      $success = $user->save();
      if ($success) {
        Mail::to($user->email)->send(new VendorAccountActivated($user));
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
  public function sendEmailLink(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
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
        Mail::to($data['email'])->send(new PasswordReset($password,$details));
        // Mail::to($data['email'])->send(new VendorResetPassword($password));
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

  //password reset
  public function resetPassword(Request $request)
  {
    $token = $request->token;
    if (!$passwordRests = DB::table('password_resets')->where('token', $token)->first()) {
      return response([
        'message' => 'Invalid Token!'
      ], 400);
    }

    if (!$user = User::where('email', $passwordRests->email)->first()) {
      return response([
        'message' => 'User doesn\'t exist!'
      ], 404);
    }

    $user->password = bcrypt($request->password);
    $user->save();
    return response([
      'message' => "Password reset!"
    ], 200);
  }

  public function changePassword(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'old_password' => 'required',
        'password' => 'required|min:6',
        'confirm_password' => 'required|min:6|same:password',

      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
        exit;
      }
      if (Hash::check($request->old_password, auth()->user()->password)) {

        $user = User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
        return response()->json([
          "message" => "Password has been changed",
        ], 200);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function imageProcessing($type, $image)
  {
    $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
    $thumbPath = public_path('images/thumbnail');
    $mainPath = public_path('images/main');
    $listingPath = public_path('images/listing');

    $img1 = Image::make($image->getRealPath());
    $img1->fit(530, 300)->save($thumbPath . '/' . $input['imagename']);


    $img2 = Image::make($image->getRealPath());
    $img2->fit(99, 88)->save($listingPath . '/' . $input['imagename']);

    $destinationPath = public_path('/images');
    return $input['imagename'];
  }
}
