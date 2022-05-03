<?php

namespace Modules\User\Http\Controllers;

use App\Service\ImageService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Profile;
use Modules\User\Entities\Address;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Front\Transformers\CustomerResource;
use DB;
use App\Models\User;
use App\Rules\Mobile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;



class ProfileController extends Controller
{

  protected $imageService;

  public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

  public function index()
  {
    return view('user::index');
  }

  public function getAddress()
    {
        return response()->json([
            'data' => auth()->user()->address
        ], 200);
    }

  public function editAddress(Request $request, User $user)
  {
    try {
      $validator = Validator::make($request->all(), [
        'full_name' => 'sometimes',
        'email' => 'sometimes|email',
        'phone' => ['required', new Mobile],
        // 'phone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
        'country' => "sometimes",
        'city' => 'sometimes',
        'street_address' => 'sometimes',
        'nearest_landmark' => "sometimes",
        'company_name' => "sometimes",
        'vat' => "sometimes",
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
        exit;
      }
      // save the address
      $address = [
        'full_name' => $request->full_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'country' => $request->country,
        'city' => $request->city,
        'street_address' => $request->street_address,
        'nearest_landmark' => $request->nearest_landmark,
        'company_name' => $request->company_name,
        'vat' => $request->vat,
      ];
      $user->address()->updateOrCreate([
          'type' => null
        ], $address);

      return response()->json([
        "message" => "Address Updated Successfully!!",
      ], 200);
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function edit(User $user)
  {
    return CustomerResource::make($user);
  }

  public function update(Request $request, User $user)
  {
    try {
      $validator = Validator::make($request->all(), [
        'full_name' => 'nullable',
        'email' => 'nullable',
        'birthday' => 'nullable|',
        'gender' => 'sometimes',
        'phone_num' => ['required', new Mobile],
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
        exit;
      }
      $formInput = $request->except('publish');
      $formInput['publish'] = 1;
      // if ($request->hasFile('image')) {
      //   if ($user->image) {
      //     $this->unlinkImage($user->image);
      //   }
      //   if ($request->image) {
      //     $image = $this->imageProcessing('img-', $request->file('image'));
      //     $formInput['image'] = $image;
      //   }
      // }
      $user->update($formInput);

      return response()->json([
        "message" => "User Profile updated Successfully!!",
        "data" => $user
      ], 200);
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function updateImage(Request $request, User $user){
    try {
      $validator = Validator::make($request->all(), [
        'avatar' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
        exit;
      }
      //upload image
      if ($request->hasFile('avatar')) {
        $this->deleteMainUserImage($user);
        $user->image = $this->imageService->storeImage($request->file('avatar'));
    }
       $user->update();
      
      return response()->json([
        "message" => "User Profile updated Successfully!!",
        "data" => $user
      ], 200);
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }
  
  public function profileImage(User $user)
  {
    return CustomerResource::make($user);
  }


  protected function deleteMainUserImage(User $user)
  {
      if ($user->image) {
          $this->imageService->unlinkImage($user->image);
      }
  }
}
