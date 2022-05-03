<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    protected $table='password_resets';
    protected $fillable=['email','token'];

}
