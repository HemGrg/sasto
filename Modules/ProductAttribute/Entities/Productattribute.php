<?php

namespace Modules\ProductAttribute\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ProductAttribute\Entities\CategoryAttribute;

class Productattribute extends Model
{
    protected $fillable  = ['title','publish','options'];
    protected $guarded = ['id', 'created_at', 'updated_at'];



    public function product_attribute_values(){
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function category_attributes(){
        return $this->hasMany(CategoryAttribute::class,'attribute_id');
    }

}
