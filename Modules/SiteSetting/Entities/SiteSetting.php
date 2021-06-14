<?php

namespace Modules\SiteSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table='site_settings';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
