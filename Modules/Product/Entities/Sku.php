<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Variant;
use Modules\ProductAttribute\Entities\Productattribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sku extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function variants(){
        return $this->hasMany(Variant::class);
    }

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\SkuFactory::new();
    }
}
