@extends('message::layouts.master')

@section('content')
<div class="messaging-page no-gutters">
    <div class="inbox-wrapper border-right py-2 col-xl-2 col-lg-2 col-md-3 col-sm-3 col-2">
        <a href="/dashboard" class="py-3 py-md-2 px-md-4 px-2 border-bottom text-center router-link-active">
            <img src="/images/logo.png" alt="Sasto Wholesale" style="max-height: 35px;" class="img-fluid">
        </a>
        <h5 class="chat-title"><a href="/dashboard"><i class="fa fa-arrow-left"></i></a> Chats</h5>
        <div class="inbox-list">
            {{-- active_chat --}}
            <inbox-list :user="{{ $user }}"></inbox-list>
        </div>
    </div>
    <div class="messaging-right col-xl-10 col-lg-10 col-md-9 col-sm-9 col-10">
        <chatbox :user="{{ $user }}" :vendor-user-id="{{ auth()->id() }}" :chat-room="{{ $chatRoom }}"></chatbox>
    </div>
</div>
@endsection
