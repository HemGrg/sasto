<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use  Modules\Order\Entities\Order;
use  Modules\Product\Entities\Product;
use Modules\Country\Entities\Country;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\Category;
use Modules\Quotation\Entities\Quotation;

class Vendor extends Model
{
    use SoftDeletes, Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'shop_name',
                'separator' => '-'
            ]
        ];
    }

    public function imageUrl($size = null)
    {
        if (!$this->image) {
            $queryString = [
                'name' => $this->shop_name,
                'background' => 'b8daff',
                'color' => '0D8ABC',
                'size' => '400'
            ];

            return 'https://ui-avatars.com/api/?' . http_build_query($queryString);
        }

        if ($size == 'thumbnail') {
            return asset('images/thumbnail/' . $this->image);
        }

        return asset('images/listing/' . $this->image);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_vendors', 'vendor_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


    public function order()
    {
        return $this->belongsTo(Order::class, 'vendor_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class);
    }
}
