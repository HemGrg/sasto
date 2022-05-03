<?php

namespace Modules\ProductAttribute\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Category\Entities\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id','category_id','subcategory_id'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subcategory(){
         return $this->belongsTo(Subcategory::class,'subcategory_id');
    }

    protected static function newFactory()
    {
        return \Modules\ProductAttribute\Database\factories\CategoryAttributeFactory::new();
    }
}
