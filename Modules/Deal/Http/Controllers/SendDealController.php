<?php

namespace Modules\Deal\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Deal\Entities\Deal;
use Modules\Message\Entities\ChatRoom;
use Modules\Message\Entities\Message;
use Modules\Message\Events\NewMessageEvent;

class SendDealController extends Controller
{
    public function send(Deal $deal)
    {
        $chatRoom = ChatRoom::where('customer_user_id', $deal->customer_id)
            ->where('vendor_user_id', $deal->vendor_user_id)
            ->first();

        // Create chat room if not exists
        if (!$chatRoom) {
            $chatRoom = ChatRoom::create([
                'customer_user_id' => $deal->customer_id,
                'vendor_user_id' => $deal->vendor_user_id,
            ]);
        }

        $message = Message::create([
            'message' => config('constants.customer_app_url') . '/deals/' . $deal->id,
            'chat_room_id' => $chatRoom->id,
            'sender_id' => $deal->vendor_user_id,
        ]);

        broadcast(new NewMessageEvent($chatRoom, $message))->toOthers();
        
        return redirect()->route('chatroom.show', $chatRoom);
    }
}
