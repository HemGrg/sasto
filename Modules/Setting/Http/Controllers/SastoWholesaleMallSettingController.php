<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Vendor;

class SastoWholesaleMallSettingController extends Controller
{
    public function index()
    {
        $title = 'SastoWholesale Mall Setting';
        $vendors = Vendor::with('user')
           ->whereHas('user', function ($q) {
                $q->where('vendor_type',  'approved');
            })
        ->select('id', 'shop_name')->get();

        return view('setting::sasto-wholesale-mall-setting',[
            'title' => $title,
            'vendors' => $vendors
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        
        $request->validate([
            'sasto_wholesale_mall_vendor_id' => 'nullable',
            'sasto_wholesale_mall_home_products_count' => 'nullable'
        ]);

        settings()->set([
            'sasto_wholesale_mall_vendor_id' => $request->sasto_wholesale_mall_vendor_id,
            'sasto_wholesale_mall_home_products_count' => $request->sasto_wholesale_mall_home_products_count
        ]);

        return redirect()->back()->with('success', 'Settings has been updated successfully.');
    }
}
