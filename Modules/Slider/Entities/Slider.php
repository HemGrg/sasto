<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function imageUrl($size = null)
    {
        // return "https://picsum.photos/400";

        if ($size == 'thumbnail') {
            return asset('images/thumbnail/' . $this->image);
        }

        return asset('images/listing/' . $this->image);
    }

    public function scopePublished($query)
    {
        return $query->where('status','publish');
    }

    public function scopeOrdered($query, $value)
    {
        return $query->where('created_at', $value);
    }
    
}
