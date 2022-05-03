<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;


class Blog extends Model
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

    public function imageUrl()
    {
        return Storage::disk('public')->url($this->image);
    }

    public function deleteImage()
    {
        return Storage::delete($this->image);
    }

    public function scopePublished($query, $is_active = true)
    {
        return $query->where('is_active', $is_active ? 1 : 0);
    }
    
    
}
