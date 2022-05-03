<?php

namespace Modules\AlternativeUser\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AlternativeUser extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['password'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function hasPermission($permission)
    {
        return $this->permissions && in_array($permission, $this->permissions);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
