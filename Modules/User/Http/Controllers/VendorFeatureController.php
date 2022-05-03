<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Vendor;

class VendorFeatureController extends Controller
{
    public function store(Request $request,  Vendor $vendor)
    {
        $vendor->update(['is_featured' => 1]);
        return response()->json([
            "status" => "true",
            "message" => "Vendor Allowed in Home page!!"
        ], 200);
    }


    public function destroy(Request $request,  Vendor $vendor)
    {
        $vendor->update(['is_featured' => 0]);
        return response()->json([
            "status" => "true",
            "message" => "Vendor Disabled in Home page!!"
        ], 200);
    }
}
