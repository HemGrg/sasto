<?php

namespace Modules\Product\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\ProductAttribute\Entities\Productattribute;
use Modules\Product\Entities\Product;


class Variant extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function attribute(){
        return $this->belongsTo(Productattribute::class,'attribute_id');
    }
    
    
}
