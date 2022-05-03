<?php

namespace Modules\Role\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role_user extends Model
{
    use HasFactory;
    protected $table = 'role_user';

    protected $fillable = ['role_id','user_id'];

    // public function user()
    // {
    //     return $this->belongsTo('App\Models\User', 'user_id', 'role_id');
    // }

    // public function role()
    // {
    //     return $this->belongsTo('Modules\Role\Entities\Role', 'role_id', 'user_id');
    // }
}
