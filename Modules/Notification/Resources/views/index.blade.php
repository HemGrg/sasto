@extends('layouts.admin')

@section('title', 'Notifications')

@push('styles')
<style>
    .notification-tabs {
        position: relative;
        background-color: #fff;
        padding: 10px 10px 0 10px;
    }

    .notification-tabs::after {
        content: "";
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
        border-bottom: 1px solid #cfe4f6;
    }

    .notification-tabs .item {
        padding: 10px 15px;
        margin-bottom: 0;
        border: 0;
        background-color: transparent;
        color: inherit;
    }

    .notification-tabs .item:focus {
        outline: 0;
        background-color: #cfe4f6;
    }

    .notification-tabs .item:hover {
        color: #4e6de6;
    }

    .notification-tabs .item.active {
        font-weight: 600;
        color: #4e6de6;
        border-bottom: 2px solid #4e6de6;
        z-index: 1;
    }

    .notification-wrapper {
        display: flex;
        width: 100%;
        color: inherit;
    }

    .notification {
        display: flex;
        width: 100%;
        color: #141b29;
        justify-content: space-between;
        padding: 15px;
        background-color: #fff;
        border-bottom: 1px solid #f2f7fb;
        border-radius: 4px;
    }

    .notification.unread {
        /* background-color: #f4faff; */
    }

    .notification:last-of-type {
        border-bottom: none;
    }

    .notification:hover {
        background-color: #fcfcfc;
        cursor: pointer;
    }

    .notification .icon {
        align-self: center;
        margin-right: 15px;
        color: #a9aaad;
        font-size: 1em;
        min-width: 30px;
    }

    .notification.unread .icon {
        color: #4e6de6;
    }

    .notification .icon i {
        font-size: 1.5rem;
    }

    .notification .body {
        flex: 1;
    }

    .notification .title {
        font-size: 1.1em;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .notification .time {
        color: #83878a;
        font-size: .9em;
    }

    .notification .delete {
        align-self: center;
        color: red;
    }

    .notification .delete button {
        color: inherit;
        border: none;
        background: transparent;
    }

</style>
@endpush
@section('content')
<div class="p-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <h5 class="page-title">Notifications</h5>
                </div>

                <x-alerts></x-alerts>

                <div class="d-flex notification-tabs">
                    <a class="item @if($filter == 'all') active @endif" href="/notifications?filter=all">All</a>
                    <a class="item @if($filter == 'unread') active @endif" href="/notifications?filter=unread">Unread</a>
                    <a class="item @if($filter == 'read') active @endif" href="/notifications?filter=read">Read</a>
                </div>

                <div class="my-3"></div>

            </div>
        </div>

        @forelse($notifications as $notification)
        <a class="notification-wrapper mb-2" href="{{ route('notifications.show', $notification->id) }}">
            <div class="notification shadowsm border {{ $notification->read_at ? : 'unread' }}">
                <div class="icon"><i class="fa fa-bell"></i></div>
                <div class="body">
                    <div class="title">{{ $notification->data['message'] ?? null }}</div>
                    <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
                <div class="delete pl-2">
                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit"><i class="fa fa-times-circle"></i></button>
                    </form>
                </div>
            </div>
        </a>
        @empty
        <div class="ibox">
            <div class="ibox-body">
                <div class="text-center">
                    No Notifications Yet !!!
                </div>
            </div>
        </div>
        @endforelse

        @if ($notifications->hasPages())
        <div class="d-flex justify-content-center py-3">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
