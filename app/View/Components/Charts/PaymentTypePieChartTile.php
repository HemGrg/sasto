<?php

namespace App\View\Components\Charts;

use Illuminate\View\Component;

class PaymentTypePieChartTile extends Component
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
        return view('components.charts.payment-type-pie-chart-tile');
    }
}
