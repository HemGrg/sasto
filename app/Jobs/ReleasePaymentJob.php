<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Transaction;
use Modules\Payment\Service\TransactionService;
use Modules\User\Entities\Vendor;

class ReleasePaymentJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $transactionService = App::make(TransactionService::class);
            $isCod = $this->order->payment_type == 'cod' ? true : false;
            $vendor = $this->order->vendor;
            $currentBalance = $transactionService->getCurrentBalance($vendor->id);

            $amountBeforeCommission = $this->order->total_price;
            $commission = $transactionService->calculateCommission($this->order->total_price, $vendor->commission_rate ?? 0);
            $amountAfterCommission = $amountBeforeCommission - $commission;

            $transaction = new Transaction();
            $transaction->vendor_id = $vendor->id;
            $transaction->type = 1;
            $transaction->amount_before_commission = $amountBeforeCommission;
            $transaction->commission = $commission;
            $transaction->amount = $amountAfterCommission;
            $transaction->running_balance = $isCod
                ? $amountAfterCommission
                : ($currentBalance + $amountAfterCommission);
            $transaction->remarks = 'Order #' . $this->order->id;
            $transaction->is_cod = $isCod;
            $transaction->save();
        } catch (\Throwable $th) {
            report($th);
            logger('Failed to release payment of order #' . $this->order->id);
            throw $th;
        }
    }
}
