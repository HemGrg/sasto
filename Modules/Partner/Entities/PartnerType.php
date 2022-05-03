<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Partner\Entities\BecomePartner;

class PartnerType extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    public function partnerRequests()
    {
        return $this->hasMany(BecomePartner::class);
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }

    public function scopePositioned($query)
    {
        return $query->orderByRaw('ISNULL(position), position ASC');
    }

    public static function getNextPosition()
    {
        return PartnerType::max('position') + 1;
    }

    public function canBeDeletedSafely()
    {
        return ($this->partners()->count() > 0) ? false : true;
    }    
}
