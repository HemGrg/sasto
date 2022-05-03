<?php

namespace Modules\Order\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Order\Entities\Order;

class CancelUnpaidOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger('Cancelling unpaid orders');

        $orders = Order::where('payment_type', '!=', 'cod')
            ->where('payment_status', 'pending')
            ->where('status', 'pending')
            ->whereDate('created_at', '<', Carbon::now()->subMinutes(5)->toDateTimeString())
            ->update([
                'status' => 'cancelled',
                'cancel_reason' => 'Order cancelled due to payment not being made.',
            ]);

        logger('No. of orders cancelled: ' . $orders);
    }
}
