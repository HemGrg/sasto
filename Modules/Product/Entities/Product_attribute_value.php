<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class Product_attribute_value extends Model
{

    protected $guarded = ['id','created_at','updated_at'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
}
