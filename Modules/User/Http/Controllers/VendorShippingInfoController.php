<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Vendor;

class VendorShippingInfoController extends Controller
{
    
    public function create(Vendor $vendor)
    {
        $updateMode = false;
        if ($vendor->shipping_info != null) {
            $updateMode = true;
        }
        return view('user::shipping_info',compact('updateMode','vendor'));
    }

    public function store(Request $request)
    {
        $vendor = Vendor::where('user_id',auth()->user()->id)->update(
            ['shipping_info' =>  request('shipping_info')]
        );
        return redirect()->back()->with('success','shipping Info added successfully!!');
    }

}
