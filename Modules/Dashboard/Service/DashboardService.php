<?php

namespace Modules\Dashboard\Service;

use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Transaction;
use Modules\Payment\Service\TransactionService;

class DashboardService
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function getTotalSales()
    {
        // return Transaction::where('type', 1)->sum('amount');
        return Order::whereNotIn('status', ['cancelled', 'refunded'])->sum('total_price');
    }

    public function getSalesFromOnlinePayment()
    {
        // $salesFromOnlinePayment = Transaction::where('type', 1)->where('is_cod', '!=', true)->sum('amount');
        $salesFromOnlinePayment = Order::whereNotIn('status', ['cancelled', 'refunded'])->where('payment_type', '!=', 'cod')
            // ->when(auth()->user()->hasRole('vendor'), function ($query) {
            //     $query->where('id', auth()->user()->vendor->id);
            // })
            ->sum('total_price');
        return $salesFromOnlinePayment;
    }

    public function getSalesFromCOD()
    {
        // $salesFromCOD = Transaction::where('type', 1)->where('is_cod', true)->sum('amount');
        $salesFromCOD = Order::whereNotIn('status', ['cancelled', 'refunded'])->where('payment_type', 'cod')
            // ->when(auth()->user()->hasRole('vendor'), function ($query) {
            //     $query->where('vendor_id', auth()->user()->vendor->id);
            // })
            ->sum('total_price');
        return $salesFromCOD;
    }

    public function getReceivableFromAdmin($vendorId)
    {
        return $this->transactionService->getCurrentBalance($vendorId);
    }
}
