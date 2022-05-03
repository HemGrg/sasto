<?php

namespace Modules\Message\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Message\Entities\Message;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Message\Entities\ChatRoom;
use Modules\Message\Events\NewMessageEvent;
use Modules\Message\Transformers\MessageCollection;
use Modules\Message\Transformers\MessageResource;

class MessageController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index($chatRoomId)
    {
        $messages = Message::where('chat_room_id', $chatRoomId)
            ->when(request()->filled('before'), function ($query) {
                return $query->where('id', '<', request('before'));
            })
            ->latest('id')
            ->cursorPaginate(request('per_page') ?? 30)->withQueryString();

        return new MessageCollection($messages);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, ChatRoom $chatRoom)
    {
        // TODO::authorize request

        $this->validate($request, [
            'type' => 'nullable',
            'file' => 'nullable|max:2048|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx',
            'message' => ['sometimes', 'required_without:file'],
        ]);

        $message = new Message([
            'chat_room_id' => $chatRoom->id,
            'sender_id' => auth()->user()->id,
        ]);

        switch ($request->type) {
            case 'file':
                $message->type = 'file';
                $message->file = $request->file('file')->store('chat_files');
                break;

            case 'product':
                $message->type = 'product';
                $message->key = $request->key;
                break;

            default:
                $message->type = 'text';
                $message->message = $request->message;
        }

        $message->message = $request->message;

        $message->save();

        // Update the chatroom
        $chatRoom->update([
            'last_message_id' => $message->id,
            'has_unseen_messages' => true,
            'updated_at' => now()
        ]);

        try {
            broadcast(new NewMessageEvent($chatRoom, $message))->toOthers();
        } catch (\Throwable $th) {
            report($th);
        }

        return response()->json([
            'ts' => $request->ts ?? null,
            'data' => new MessageResource($message)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json(['status' => 'success'], 204);
    }

    public function markSeen(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required',
            'last_message_id' => 'required',
        ]);

        Message::where('chat_room_id', $request->chat_room_id)
            ->where('sender_id', '!=', auth()->id())
            ->where('id', '<=', $request->last_message_id)
            ->update(['seen' => true]);

        ChatRoom::where('id', $request->chat_room_id)
            ->update([
                'has_unseen_messages' => false,
            ]);
    }
}
