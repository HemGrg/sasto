<?php

namespace Modules\ProductCategory\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Product;
use Modules\Subcategory\Entities\Subcategory;

class ProductCategory extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $cast = [
        'is_featured' => 'boolean',
        'publish' => 'boolean',
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

        // if ($size == 'thumbnail') {
        //     return asset('images/thumbnail/' . $this->image);
        // }

        return Storage::disk('public')->url($this->image);
    }

    public function scopePublished($query)
    {
        return $query->where('publish', true);
    }

    protected static function newFactory()
    {
        return \Modules\ProductCategory\Database\factories\ProductCategoryFactory::new();
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
