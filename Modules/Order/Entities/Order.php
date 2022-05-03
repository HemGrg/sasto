<?php

namespace Modules\Order\Entities;

use App\Jobs\ReleasePaymentJob;
use Illuminate\Database\Eloquent\Model;
use  Modules\Product\Entities\Product;
use  Modules\User\Entities\Vendor;
use Modules\Order\Entities\OrderList;
use  App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Modules\Payment\Service\TransactionService;
use Modules\User\Entities\Address;

class Order extends Model
{
	use SoftDeletes;

	protected $guarded = ['id', 'created_at', 'updated_at'];

	protected static function booted()
	{
		static::addGlobalScope(function (Builder $builder) {
			$builder->when(auth()->check() && auth()->user()->hasRole('vendor'), function ($query) {
				return $query->where('vendor_id', auth()->user()->vendor->id);
			});

			// filter order for customer
			$builder->when(auth()->check() && auth()->user()->hasRole('customer'), function ($query) {
				return $query->where('user_id', auth()->user()->id);
			});
		});

		// static::updating(function ($order) {
		//     if ($order->status == 'completed' && ($order->status != $order->getOriginal('status'))) {
		// 		// Add transaction
		// 		foreach($order->packages as $package) {
		// 			app(new \Modules\Payment\Service\TransactionService)->deposit($package->vendor_user_id, $package->total_price, 'Order #' . $order->id);
		// 		}
		// 	}
		// });
	}

	public function isPaid()
	{
		return $this->payment_status == 'paid';
	}

	public function isDealCheckout()
	{
		return $this->deal_id;
	}

	public function scopeCreatedBetweenDates($query, array $dates)
	{
		$start = ($dates[0] instanceof Carbon) ? $dates[0] : Carbon::parse($dates[0]);
		$end   = ($dates[1] instanceof Carbon) ? $dates[1] : Carbon::parse($dates[1]);

		return $query->whereBetween('created_at', [
			$start->startOfDay(),
			$end->endOfDay()
		]);
	}


	public function customer()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class);
	}

	// public function packages()
	// {
	// 	return $this->hasMany(Package::class);
	// }

	public function orderLists()
	{
		return $this->hasMany(OrderList::class, 'order_id');
	}

	public function billingAddress()
	{
		return $this->morphOne(Address::class, 'addressable')->where('type', 'billing');
	}

	public function shippingAddress()
	{
		return $this->morphOne(Address::class, 'addressable')->where('type', 'shipping');
	}

	// Can be deleted safely
	public function syncStatusFromPackages()
	{
		if ($this->status === 'pending') {
			if ($this->packages()->whereIn('status', ['processing', 'shipped', 'completed'])->count()) {
				$this->update(['status' => 'processing']);
			}
		}

		if ($this->status === 'processing') {
			if ($this->packages()->where('status', ['shipped', 'completed'])->count()) {
				$this->update(['status' => 'shipped']);
			}
		}

		if ($this->status === 'shipped') {
			if (!$this->packages()->where('status', '!=', 'completed')->count()) {
				$this->update(['status' => 'completed']);
				ReleasePaymentJob::dispatch($this);
				// $transactionService = App::make(TransactionService::class);
				// foreach($this->packages as $package) {
				// 	$isCod = $this->payment_type == 'cod' ? true : false;
				// 	$transactionService->deposit($package->vendor_user_id, $package->total_price, $isCod, 'Order #' . $this->id);
				// }
			}
		}
	}
}
