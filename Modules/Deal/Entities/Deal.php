<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Deal\Entities\DealProduct;
use Modules\Product\Entities\Product;
use App\Traits\Uuid;
use App\Models\User;
use Illuminate\Notifications\Notifiable;
use Modules\User\Entities\Vendor;

class Deal extends Model
{
  use Uuid, Notifiable;

  public $incrementing = false;

  protected $keyType = 'uuid';
  protected $guarded = ['id', 'created_at', 'updated_at'];

  protected $dates = ['expire_at'];

  public function subTotalPrice()
  {
    return $this->dealProducts->sum(function ($product) {
      return $product->product_qty * $product->unit_price;
    });
  }

  public function totalShippingCharge()
  {
    return $this->dealProducts->sum(function ($product) {
      return $product->shipping_charge ?? 0;
    });
  }

  public function totalPrice()
  {
    return $this->subTotalPrice() + $this->totalShippingCharge();
  }

  public function isAvailable()
  {
    if ($this->completed_at) {
      return false;
    }

    return $this->expire_at->isFuture();
  }

  public function markCompleted()
  {
    return $this->update(['completed_at' => now()]);
  }

  // WARNING::relationship name should always be camel case like dealProduct
  // cannot delete it currently since its being used in DealProductController
  public function deal_products()
  {
    return $this->hasMany(DealProduct::class);
  }

  public function dealProducts()
  {
    return $this->hasMany(DealProduct::class, 'deal_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'customer_id');
  }

  public function vendor()
  {
    return $this->belongsTo(User::class, 'vendor_user_id');
  }

  public function vendorShop()
  {
    return $this->belongsTo(Vendor::class, 'vendor_user_id', 'user_id');
  }
}
