<?php

namespace App\View\Components\Charts;

use Carbon\Carbon;
use Illuminate\View\Component;
use Modules\User\Entities\Vendor;

class SalesChartTile extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // $vendors = Vendor::get();
        $vendors = Vendor::whereHas('user', function($q){
            $q->where('vendor_type', 'approved');
        })->get();
        return view('components.charts.sales-chart-tile', [
            'from' => Carbon::now()->subDays(30)->format('Y-m-d'),
            'to' => Carbon::now()->format('Y-m-d'),
            'vendors' => $vendors
        ]);
    }
}
