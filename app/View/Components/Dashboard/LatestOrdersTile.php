<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;
use Modules\Order\Entities\Order;

class LatestOrdersTile extends Component
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
        $orders = Order::with(['orderLists', 'vendor', 'customer'])
            ->whereIn('status', ['pending', 'processing', 'shipped'])
            ->latest()
            ->limit(10)->get();

        return view('components.dashboard.latest-orders-tile', [
            'orders' => $orders
        ]);
    }
}
