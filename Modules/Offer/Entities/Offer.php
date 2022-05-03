<?php

namespace Modules\Offer\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Product\Entities\Product;

class Offer extends Model
{
    use Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'separator' => '_'
            ]
        ];
    }
    
    public function product(){
        return $this->hasOne(Product::class,'offer_id');
    }
}
