<?php

namespace Modules\Subscriber\Entities;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    
}
