<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Subcategory\Entities\Subcategory;
use Modules\ProductAttribute\Entities\CategoryAttribute;
use Modules\Product\Entities\Product;
use Modules\ProductCategory\Entities\ProductCategory;
use Modules\User\Entities\Vendor;

class Category extends Model
{
    use Sluggable;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'separator' => '_'
            ]
        ];
    }


    public function products()
    {
        return $this->hasManyDeep(Product::class, [Subcategory::class, ProductCategory::class]);
    }

    public function imageUrl($size = null)
    {
        if ($size == 'thumbnail') {
            return asset('images/thumbnail/' . $this->image);
        }

        return asset('images/listing/' . $this->image);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'category_vendors', 'category_id', 'vendor_id');
    }

    public function subcategory()
    {
        return $this->hasMany(Subcategory::class);
    }
    
    public function productCategory()
    {
        return $this->hasManyThrough(ProductCategory::class, Subcategory::class, 'category_id', 'subcategory_id');
    }

    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }

    public function attributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    public function scopePublished($query)
    {
        return $query->where('publish', 1);
    }
}
