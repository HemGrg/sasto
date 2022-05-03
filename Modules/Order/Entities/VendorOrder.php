<?php

namespace Modules\Order\Entities;
use Modules\Order\Entities\OrderList;

use Illuminate\Database\Eloquent\Model;

class VendorOrder extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    
    public function orderlist(){
		  return $this->hasMany(OrderList::class,'order_id');
	  }
}
