<?php

namespace Modules\Notification\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $notifications = Auth::user();
        // dd($filter);

        if ($filter == 'unread') {
            $notifications = $notifications->unreadNotifications();
        } elseif ($filter == 'read') {
            $notifications = $notifications->readNotifications();
        } else {
            $notifications = $notifications->notifications();
        }

        $notifications = $notifications->simplePaginate(30)->withQueryString();

        return view('notification::index', compact(['notifications', 'filter']));
    }

    public function show($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)->firstOrFail();

        $notification->markAsRead();

        return redirect($notification->data['url']);
    }

    public function destroy($id)
    {
        auth()->user()
            ->notifications()
            ->where('id', $id)
            ->delete();

        return redirect()->back();
    }

    public function getUnreadCount()
    {
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count()
        ], 200);
    }
}
