<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class Quantity extends Model
{

    protected $guarded = ['id','created_at','updated_at'];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    
}
