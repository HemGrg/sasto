<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Front\Transformers\AddressResource;
use Modules\Order\Entities\Order;
use Modules\Order\Jobs\CancelUnpaidOrders;

class OrderApiController extends Controller
{
    public function index()
    {
        // cancel out the unpaid orders
    //    CancelUnpaidOrders::dispatch();

        $orders = Order::with('orderLists')
            ->when(request()->filled('status'), function ($query) {
                switch (request('status')) {
                    case 'unpaid':
                        return $query->where('payment_status', 'pending');
                        break;
                    case 'processing':
                        return $query->where('status', 'pending')
                            ->orWhere('status', 'processing')
                            ->orWhere('status', 'shipped');
                        break;
                    case 'delivered':
                        return $query->where('status', 'completed');
                        break;
                    case 'cancelled':
                        return $query->where('status', 'cancelled');
                        break;
                    default:
                        return $query->where('status', request('status'));
                        break;
                }
            })
            ->latest()
            ->paginate();

        foreach ($orders as $order) {
            $order->orderLists->map(function ($orderList) {
                $orderList['product_image_url'] = $orderList->product ? $orderList->product->imageUrl('thumbnail') : 'no_image';
                unset($orderList->product);
                return $orderList;
            });
        }

        return $orders;
    }

    public function show(Order $order)
    {
        abort_unless(auth()->check() && $order->user_id == auth()->user()->id, 403);

        $order->loadMissing(['orderLists.product:id,title,image,image_thumbnail', 'vendor:id,user_id,shop_name', 'shippingAddress', 'billingAddress']);
        $order->sold_by = $order->vendor->shop_name;
        $order->orderLists->map(function ($orderList) {
            $orderList['product_image_url'] = $orderList->product ? $orderList->product->imageUrl('thumbnail') : 'no_image';
            unset($orderList->product);
            return $orderList;
        });

        $order->status_number = get_order_status_number($order->status);
        $order->can_cancel_order = can_cancel_order($order->status);
        // $order['shipping_address'] = new AddressResource($order->shippingAddress);
        // $order->billing_address = AddressResource::make($order->shippingAddress);

        return response()->json($order, 200);
    }

    public function cancelOrder(Order $order)
    {
        abort_unless(auth()->check() && $order->user_id == auth()->user()->id, 403);
        can_cancel_order($order->status);

        $order->update(['status' => 'cancelled']);
        foreach (admin_users() as $admin) {
            $admin->notify(new \Modules\Order\Notifications\OrderCancelledNotification($order));
        }
        $order->vendor->user->notify(new \Modules\Order\Notifications\OrderCancelledNotification($order));

        return response()->json(['message' => 'Your order has been cancelled successfully.'], 200);
    }
}
