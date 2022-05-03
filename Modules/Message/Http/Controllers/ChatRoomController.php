<?php

namespace Modules\Message\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Message\Entities\ChatRoom;

class ChatRoomController extends Controller
{
    public function index()
    {
        $activeChatRoom = ChatRoom::with('customerUser')->where('vendor_user_id', auth()->id())->first();

        if (!$activeChatRoom) {
            return view('message::chat.no-chat-room');
        }

        return redirect()->route('chatroom.show', $activeChatRoom);
    }

    public function show(ChatRoom $chatRoom)
    {
        $chatRoom->load('customerUser');

        return view('message::chat.show', [
            'user' => auth()->user(),
            'chatRoom' => $chatRoom
        ]);
    }
}
