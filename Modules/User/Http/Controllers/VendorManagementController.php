<?php

namespace Modules\User\Http\Controllers;

use App\Mail\VendorStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Vendor;
use App\Models\User;
use App\Rules\Mobile;
use Modules\Category\Entities\Category;
use Modules\Country\Entities\Country;
use File, Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use Modules\Front\Notifications\VendorStatusChangeMessageNotification;
use Modules\Product\Entities\Product;
class VendorManagementController extends Controller
{
   public function getApprovedVendors()
   {
      $vendors = Vendor::with('user')->whereHas('user', function ($q) {
         $q->where('vendor_type',  'approved');
      })->latest()->get();
      return view('user::vendors-list', compact('vendors'));
   }

   public function getSuspendedVendors()
   {
      $vendors = Vendor::with('user')->whereHas('user', function ($q) {
         $q->where('vendor_type',  'suspended');
      })->latest()->get();
      return view('user::vendors-list', compact('vendors'));
   }

   public function getNewVendors()
   {
      $vendors = Vendor::with('user')->whereHas('user', function ($q) {
         $q->where('vendor_type',  'new');
      })->latest()->get();
      return view('user::vendors-list', compact('vendors'));
   }

   public function getVendorProfile(Request $request, $username)
   {
      $user = User::where('username', $username)->with('vendor')->first();
      $categories = Category::published()->select('id', 'name', 'slug')->get();
      $countries = Country::published()->get();
      return view('user::profile', compact('user', 'categories', 'countries'));
   }

   public function getVendorProducts(Request $request, $username)
   {
      $user = User::where('username', $username)->with('products')->first();
      $products = Product::with('user.vendor')->where('vendor_id', $user->vendor->id)
         ->when(request()->filled('search'), function ($query) {
            return $query->where('title', 'like', '%' . request('search') . "%");
         })
         ->latest()
         ->paginate(request('per_page') ?? 15)
         ->withQueryString();
      return view('user::vendorproducts', compact('products'));
   }

   public function updateCommisson(Request $request)
   {
      $request->validate([
         'vendor_id'      => 'required|numeric|exists:users,id',
         'vendor_type'          => 'nullable',
         'commission_rate'          => 'nullable|numeric',
         'note'                     => 'nullable',
      ]);
      $user = User::where('id', $request->vendor_id)->first();
      if($request->vendor_type != $user->vendor_type){
         $user->update([
            'vendor_type' => $request->vendor_type
         ]);
         ($request->vendor_type === "suspended") ? 
         $user->vendor->update([
            'note' => $request->note
         ]) 
         : $user->vendor->update([
            'note' => ''
         ]);
         Mail::to($user->email)->send(new VendorStatusChanged($user));
         // $user->notify(new VendorStatusChangeMessageNotification($user));
      }
      $user->vendor->update([
         'commission_rate' => $request->commission_rate
      ]);
      
      return redirect()->back()->with('success', 'Vendor Updated Successfuly.');
   }

   public function updateVendorDetails(Request $request, Vendor $vendor)
   {
      $request->validate([
         'shop_name' => 'required',
         'company_email' => 'required',
         'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
         'product_category' => 'nullable',
         'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
      ]);

      $formInput = $request->except(['image']);
      if ($request->hasFile('image')) {
         if ($vendor->image) {
            $this->unlinkImage($vendor->image);
         }
         if ($request->image) {
            $image = $this->imageProcessing('img-', $request->file('image'));
            $formInput['image'] = $image;
         }
      }
      $formInput['business_type'] = $request->business_type;
      $vendor->update($formInput);
      $vendor->categories()->sync($request->category_id);
      return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
   }

   public function updateVendorDescription(Request $request, Vendor $vendor)
   {
      $request->validate([
         'description' => 'required',
      ]);
      $formInput = $request->except(['_token']);
      $vendor->update($formInput);
      return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
   }

   public function updateVendorBankDetails(Request $request, Vendor $vendor)
   {
      $request->validate([
         'bank_name' => 'nullable',
         'branch_name' => 'nullable',
         'account_number' => 'nullable',
         'name_on_bank_acc' => 'nullable',
         'bank_info_image' => 'mimes:jpg,png,jpeg,gif|max:3048',
      ]);
      $value = $request->except(['bank_info_image', 'token']);
      if ($request->hasFile('bank_info_image')) {
         if ($vendor->bank_info_image) {
            $this->unlinkImage($vendor->bank_info_image);
         }
         if ($request->bank_info_image) {
            $image = $this->imageProcessing('img-', $request->file('bank_info_image'));
            $value['bank_info_image'] = $image;
         }
      }

      $vendor->update($value);
      return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
   }

   public function updateShippingInfo(Request $request, Vendor $vendor){
      $request->validate([
         'shipping_info' => 'required',
      ]);
      $formInput = $request->except(['_token']);
      $vendor->update($formInput);
      return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
   }

   public function updateUserDetails(Request $request, Vendor $vendor)
   {
      $request->validate([
         'name' => 'required',
         'email' => 'required',
         'phone_num' => ['required', new Mobile],
         //  'phone_num' => 'required',
         'designation' => 'required',
      ]);
      $formInput = $request->except(['_token']);
      $vendor->user->update($formInput);
      return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
   }

   public function imageProcessing($type, $image)
   {
      $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
      $thumbPath = public_path() . "/images/thumbnail";
      if (!File::exists($thumbPath)) {
         File::makeDirectory($thumbPath, 0777, true, true);
      }
      $listingPath = public_path() . "/images/listing";
      if (!File::exists($listingPath)) {
         File::makeDirectory($listingPath, 0777, true, true);
      }
      $img1 = Image::make($image->getRealPath());
      $img1->fit(99, 88)->save($thumbPath . '/' . $input['imagename']);


      $img2 = Image::make($image->getRealPath());
      $img2->save($listingPath . '/' . $input['imagename']);

      return $input['imagename'];
   }

   public function unlinkImage($imagename)
   {
      $thumbPath = public_path('images/thumbnail/') . $imagename;
      $listingPath = public_path('images/listing/') . $imagename;
      if (file_exists($thumbPath))
         unlink($thumbPath);
      if (file_exists($listingPath))
         unlink($listingPath);
      return;
   }
}
