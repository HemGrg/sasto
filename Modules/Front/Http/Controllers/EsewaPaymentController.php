<?php

namespace Modules\Front\Http\Controllers;

use App\Service\EsewaService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;

class EsewaPaymentController extends Controller
{
    protected $esewaService;

    public function __construct(EsewaService $esewaService)
    {
        $this->esewaService = $esewaService;
    }

    public function setupPayment(Order $order)
    {
        return response()->json($this->esewaService->generatePaymentDetails($order), 200);
    }

    public function success(Request $request)
    {
        $order = Order::findOrFail($request->oid);

        $data = [
            'amt' => $order->total_price,
            'rid' => $request->refId,
            'pid' => $order->id,
        ];

        if ($this->esewaService->verifyPayment($data)) {
            $order->update([
                'payment_status' => 'paid',
                'payment_type' => 'esewa',
                'esewa_ref_id' => $request->refId
            ]);
            return redirect(config('constants.customer_app_url') . '/my-orders/' . $order->id);
        }

        return 'payment failed';
    }

    // Not used currently
    // public function failed(Request $request)
    // {
    //     return ' Esewa failed';
    // }
}
