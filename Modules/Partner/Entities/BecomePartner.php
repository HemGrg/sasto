<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Partner\Entities\PartnerType;

class BecomePartner extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function partnerType()
    {
        return $this->belongsTo(PartnerType::class);
    }
    
}
