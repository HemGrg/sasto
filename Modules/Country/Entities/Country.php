<?php

namespace Modules\Country\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Vendor;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Country extends Model
{
    use Sluggable;

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

    public function flagUrl()
    {
        return Storage::disk('public')->url($this->path);
    }

    public function deleteFlagImage()
    {
        return Storage::delete($this->path);
    }

    public function scopePublished($query, $status = true)
    {
        return $query->where('publish', $status ? 1 : 0);
    }

    public function setFlagAttribute($flag)
    {
        $url = url('/');
        $this->attributes['flag'] = ('' . $url . '/uploads/country/' . $flag . '');
        return $this->attributes['flag'];
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'country_id');
    }

    public function canBeDeletedSafely()
    {
        return ($this->vendors()->count() > 0) ? false : true;
    } 
}
