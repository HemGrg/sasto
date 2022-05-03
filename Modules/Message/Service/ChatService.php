<?php

namespace Modules\Message\Service;

class ChatService
{
    public function hasUnreadMessages($userId)
    {
        $chatRooms = ChatRoom::where('vendor_user_id', $userId)
            ->orWhere('customer_user_id', $userId)
            ->whereHas('messages', function ($query) use ($userId) {
                $query->where('sender_id', '!=', $userId)
                    ->where('is_read', 0);
            })
            ->get();

        return $chatRooms->count() > 0;
    }
}
