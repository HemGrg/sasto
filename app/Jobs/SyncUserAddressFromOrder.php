<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Entities\Order;

class SyncUserAddressFromOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order)
    {
        $this->user = $user;
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
            // if user does not have an address set
            if (!$this->user->address()->count()) {
                $address = $this->order->billingAddress;
                $this->user->address()->create([
                    'type' => 'null',
                    'full_name' => $address->full_name,
                    'company_name' => $address->company_name,
                    'vat' => $address->vat,
                    'country' => $address->country,
                    'city' => $address->city,
                    'street_address' => $address->street_address,
                    'nearest_landmark' => $address->nearest_landmark,
                    'phone' => $address->phone,
                    'email' => $address->email,
                ]);
            }
        } catch (\Throwable $th) {
            logger($th);
        }
    }
}
