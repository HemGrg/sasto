<?php

namespace Modules\Subcategory\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\ProductAttribute\Entities\CategoryAttribute;
use Modules\ProductCategory\Entities\ProductCategory;

class Subcategory extends Model
{
    use Sluggable;
    // use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'publish' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'separator' => '_'
            ]
        ];
    }

    public function imageUrl($size = null)
    {
        if (!$this->image) {
            $queryString = [
                'name' => $this->name,
                'background' => 'b8daff',
                'color' => '0D8ABC',
                'size' => '200'
            ];

            return 'https://ui-avatars.com/api/?' . http_build_query($queryString);
        }

        if ($size == 'thumbnail') {
            return asset('images/thumbnail/' . $this->image);
        }

        return asset('images/listing/' . $this->image);
    }

    public function scopePublished($query)
    {
        return $query->where('publish', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productCategory()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, ProductCategory::class);
    }

    public function attributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

}
