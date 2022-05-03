<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Category\Entities\Category;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Product\Entities\Quantity;
use Modules\Product\Entities\Variant;
use Modules\Product\Entities\Sku;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderList;
use Modules\Offer\Entities\Offer;
use Modules\Brand\Entities\Brand;
use Modules\User\Entities\Vendor;
use Modules\Product\Entities\ProductImage;
use Modules\Product\Entities\Range;
use Modules\Review\Entities\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\ProductAttributeValue;
use Modules\ProductCategory\Entities\ProductCategory;

class Product extends Model
{
    use SoftDeletes, Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'overview' => 'array',
        'status' => 'boolean',
        'is_top' => 'boolean',
        'is_new_arrival' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(function (Builder $builder) {
            $builder->when(auth()->check() && auth()->user()->hasRole('vendor'), function ($query) {
                return $query->where('vendor_id', auth()->user()->vendor->id);
            });
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'separator' => '_'
            ]
        ];
    }

    public function imageUrl($size = null)
    {
        if ($size == 'thumbnail') {
            return Storage::url($this->image_thumbnail);
        }

        return Storage::url($this->image);
    }

    public function priceRange()
    {
        $minPrice = $this->ranges->min('price');
        $maxPrice = $this->ranges->max('price');
        if ($minPrice == $maxPrice) {
            return 'Rs. ' . number_format(floatval($minPrice));
        }
        return 'Rs. ' . number_format(floatval($minPrice)) . ' - ' . number_format(floatVal($maxPrice));
    }

    public function getOverviewData($key)
    {
        return $this->overview[$key] ?? null;
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product_attribute_values()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function quantities()
    {
        return $this->hasMany(Quantity::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasOne(Variant::class, 'product_id');
    }

    // This relationship does not exist in the database.
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeProductsFromApprovedVendors($query)
    {
        return $query->whereHas('user', function ($q) {
                $q->where('vendor_type',  'approved');
            });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function order_list()
    {
        return $this->hasOne(OrderList::class);
    }

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    public function ranges()
    {
        return $this->hasMany(Range::class)->orderBy('from', 'asc');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function youtubeVideo($url)
    {
        $url_string = parse_url($url, PHP_URL_QUERY);
        parse_str($url_string, $args);
        return isset($args['v']) ? $args['v'] : false;
    }
}
