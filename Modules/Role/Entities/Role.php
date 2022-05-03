<?php

namespace Modules\Role\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Role extends Model
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

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_user', 'user_id', 'role_id');
    }
}
