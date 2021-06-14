<?php

namespace Modules\Category\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use Sluggable;

    protected $table='categories';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //slugable
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    
    
}
