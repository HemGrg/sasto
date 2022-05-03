<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\Vendor;

class Package extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\PackageFactory::new();
    }

    public function syncTotalPrice()
    {
        return $this->update([
            'total_price' => $this->orderLists->sum('total_price'),
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderLists()
    {
        return $this->hasMany(OrderList::class);
    }

    public function vendorUser()
	{
		return $this->belongsTo(User::class, 'vendor_user_id');
	}

    public function vendorShop()
    {
      return $this->belongsTo(Vendor::class, 'vendor_user_id', 'user_id');
    }
}
