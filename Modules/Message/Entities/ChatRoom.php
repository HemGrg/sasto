<?php

namespace Modules\Message\Entities;

use App\Models\User;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatRoom extends Model
{
    use Uuid, HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $guarded = [];
    protected $casts = ['has_unseen_messages' => 'boolean'];

    public function ping()
    {
        return $this->update([
            'last_message_at' => now()
        ]);
    }

    public function scopeMyParticipation($query)
    {
        return $query->where('customer_user_id', auth()->id())
            ->orWhere('vendor_user_id', auth()->id());
    }

    public function customerUser()
    {
        return $this->belongsTo(User::class, 'customer_user_id')
            ->withDefault([
                'name' => 'Guest'
            ]);
    }

    public function vendorUser()
    {
        return $this->belongsTo(User::class, 'vendor_user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
