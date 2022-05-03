<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Modules\Order\Entities\Package;

class PackageController extends Controller
{
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'status' => ['required', Rule::in(vendor_editable_package_status()), Rule::notIn([$package->status])],
            'update_silently' => 'nullable'
        ]);

        try {
            DB::beginTransaction();
            $package->update(['status' => $request->status]);

            // sync order status change
            $order = $package->order;
            if ($package->wasChanged('status')) {
                $order->syncStatusFromPackages();
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            report($ex);
            return redirect()->back()->with('error', 'Something went wrong while processing your request.');
        }

        if (!$request->filled('update_silently')) {
            Mail::to($order->customer->email)->send(new \App\Mail\PackageStatusChanged($package));
        }

        return redirect()->back()->with('success', 'Order Package status updated successfully.');
    }
}
