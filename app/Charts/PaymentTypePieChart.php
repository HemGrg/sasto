<?php

declare(strict_types=1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class PaymentTypePieChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $vendorId = auth()->user()->vendor->id ?? 0;

        $connectips = \DB::table('orders')->selectRaw('count(*) as count')
            ->when(auth()->user()->hasRole('vendor'), function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->where('payment_type', 'connectips')
            ->pluck('count');

        $esewa = \DB::table('orders')->selectRaw('count(*) as count')
            ->when(auth()->user()->hasRole('vendor'), function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->where('payment_type', 'esewa')
            ->pluck('count');

        $cod = \DB::table('orders')->selectRaw('count(*) as count')
            ->when(auth()->user()->hasRole('vendor'), function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->where('payment_type', 'cod')
            ->pluck('count');

        return Chartisan::build()
            ->labels(['Conenct Ips', 'E-sewa', 'COD'])
            ->dataset('Set One', [$connectips, $esewa, $cod]);
    }
}
