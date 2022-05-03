<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ReleasePaymentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Modules\Front\Notifications\OrderShippedMessageNotification;
use Modules\Order\Entities\Order;
use Modules\Order\Jobs\CancelUnpaidOrders;
use Modules\User\Entities\Vendor;

class OrderController extends Controller
{

    public function index()
    {
        $this->authorize('manageOrders');
       
        // CancelUnpaidOrders::dispatch();

        $vendors = Vendor::whereHas('user', function ($q) {
            $q->where('vendor_type', 'approved');
        })->get();
        $orders = Order::with(['orderLists', 'customer', 'vendor:id,shop_name'])
            ->when(request()->filled('order_id'), function ($query) {
                return $query->where('id', request('order_id'));
            })
            ->when(request()->filled('status'), function ($query) {
                return $query->where('status', request('status'));
            })
            ->when(request()->filled('vendor_id'), function ($query) {
                return $query->where('vendor_id', request('vendor_id'));
            })
            ->latest()
            ->paginate();

        return view('order::index', compact('orders', 'vendors'));
    }

    public function show(Order $order)
    {
        // abort_unless(auth()->user()->hasAnyRole('super_admin|admin|vendor'), 403);
        $this->authorize('manageOrders');

        if (auth()->user()->hasRole('vendor')) {
            abort_unless(auth()->user()->vendor->id == $order->vendor_id, 403);
        }

        $order->load([
            'orderLists.product:id,title,slug',
            'vendor',
            'customer:id,name,email',
            'billingAddress',
            'shippingAddress'
        ]);

        $subTotalPrice = $order->subtotal_price;
        $totalShippingPrice = $order->shipping_charge;
        $totalPrice = $order->total_price;

        $orderStatuses = config('constants.order_statuses');

        if (auth()->user()->hasRole('vendor')) {
            $orderStatuses = array_diff($orderStatuses, ['cancelled', 'refunded']);
        }

        return view('order::show', compact([
            'order',
            'subTotalPrice',
            'totalShippingPrice',
            'totalPrice',
            'orderStatuses'
        ]));
    }

    public function update(Request $request, Order $order)
    {
        // abort_unless(auth()->user()->hasAnyRole('super_admin|admin|vendor'), 403);
        $this->authorize('manageOrders');

        $orderStatuses = config('constants.order_statuses');
        if (auth()->user()->hasRole('vendor')) {
            abort_unless(auth()->user()->vendor->id == $order->vendor_id, 403);
            $orderStatuses = array_diff($orderStatuses, ['cancelled', 'refunded']);
        }

        $request->validate([
            'status' => ['required', Rule::in($orderStatuses), Rule::notIn([$order->status])],
            'update_silently' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $order->update(['status' => $request->status]);

            // Mark COD order as paid after order is completed
            if (($order->status == "completed") && ($order->payment_type == "cod")) {
                $order->update(['payment_status' => "paid"]);
            }

            if (!$request->filled('update_silently')) {
                if ($order->status == 'refunded') {
                    // send email to customer
                    Mail::to($order->customer->email)->send(new \App\Mail\OrderRefundedEmail($order));
                } else {
                    Mail::to($order->customer->email)->send(new \App\Mail\OrderStatusChanged($order));
                }

                // send email to vendor in case of cancellation
                if ($order->status == 'cancelled') {
                    $order->vendor->user->notify(new \Modules\Order\Notifications\OrderCancelledNotification($order));
                    Mail::to($order->vendor->user->email)->send(new \App\Mail\OrderCancelledEmailToVedor($order));
                }
            }

            if ($order->status == 'shipped') {
                $order->customer->notify(new OrderShippedMessageNotification($order));
            }

            if ($order->status == 'completed') {
                ReleasePaymentJob::dispatch($order);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            report($ex);
            return redirect()->back()->with('error', 'Something went wrong while processing your request.');
        }

        return redirect()->back()->with('success', 'Order status changed successfully.');
    }
}
