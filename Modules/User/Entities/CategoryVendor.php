<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryVendor extends Model
{
    protected $table = 'category_vendors';
    protected $guarded = ['id','created_at','updated_at'];
    
}
