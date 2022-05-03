<?php

namespace Modules\User\Http\Controllers;

use App\Http\Requests\VendorRequest;
use Illuminate\Routing\Controller;
use App\Mail\VendorCreated;
use App\Models\User;
use Modules\User\Entities\Vendor;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;
use DB;
use Str;
use Mail;
use Modules\User\Notifications\NewVendorRegistration;

class VendorRegistrationController extends Controller
{

  public function register(VendorRequest $request)
  {
    DB::beginTransaction();
    try {
      $name = explode(' ', $request->name);
      $username = strtolower($name[0] . rand(10, 1000));
      $data = [
        'publish' => 1,
        'username' => $username,
        'activation_link' => Str::random(63),
        'otp' =>    random_int(100000, 999999),
        'name' => $request->name,
        'email' => $request->email,
        'designation' => $request->designation,
        'gender' => $request->gender,
        'phone_num' => $request->phone_num,
        'password' => bcrypt($request->password)
      ];
      $userExist = User::create($data);

      if ($userExist) {
        $user = User::where('email', $request->email)->first();
      }

      $formData['user_id'] = $user->id;
      $formData['country_id'] = $request->country_id;
      $role = Role::where('name', 'vendor')->first();
      $role_data = [
        'role_id' => $role->id,
        'user_id' => $formData['user_id']
      ];
      $formData = $request->except('activation_link', 'terms_condition',  '_token');
      $formData['user_id'] = $user->id;
      $role_user = Role_user::create($role_data);
      $formData['phone_number'] = $request->company_phone;
      $vendor = Vendor::create($formData);
      $vendor->categories()->sync($request->category_id);
      DB::commit();
      foreach (admin_users() as $admin) {
        $admin->notify(new NewVendorRegistration($vendor));
      }
      Mail::to($request->email)->send(new VendorCreated($vendor));
      return response()->json([
        "status_code" => 200,
        "message" => "success",
        'vendor' => $vendor
      ], 200);
    } catch (\Exception $exception) {
      DB::rollback();
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }
}
