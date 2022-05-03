<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorPayment extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    
}
