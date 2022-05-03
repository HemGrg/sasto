<?php

namespace Modules\Faq\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    public function scopePublished($query, $is_active = true)
    {
        return $query->where('is_active', $is_active ? 1 : 0);
    }
    
    public function scopePositioned($query)
    {
        return $query->orderByRaw('ISNULL(position), position ASC');
    }

    public static function getNextPosition()
    {
        return Faq::max('position') + 1;
    }
}
