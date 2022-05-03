<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Deal\Entities\Deal;
use Modules\Product\Entities\Product;
use App\Models\User;

class DealProduct extends Model
{
  protected $guarded = ['id', 'created_at', 'updated_at'];

  public function subTotalPrice()
  {
    return $this->product_qty *  $this->unit_price;
  }

  public function totalPrice()
  {
    return $this->subTotalPrice() + $this->shipping_charge;
  }

  public function deal()
  {
    return $this->belongsTo(Deal::class, 'deal_id');
  }

  // relationship has been duplicated due to improper naming convention
  public function product_info()
  {
    return $this->hasOne(Product::class, 'id', 'product_id');
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function customer()
  {
    return $this->belongsTo(User::class);
  }
}
