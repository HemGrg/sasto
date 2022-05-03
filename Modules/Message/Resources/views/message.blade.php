@extends('layouts.admin')
@section('page_title','Message')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/chat.css') }}">
@endsection
@section('content')
<main>
    {{-- <form action="#" method="POST" class="userlist-form border-bottom mx-3 my-3">
        <div class="input-group w-100 bg-light">
            <input type="text" class="form-control form-control-md search border-right-0 transparent-bg pr-0"
                placeholder="Search" style="border: 12px">

            <div class="input-group-append">
                <div class="input-group-text transparent-bg border-left-0" role="button" style="padding: 14px;">
                    <img class="injectable hw-20" src="{{ asset('assets/admin/images/search.svg') }}" alt="">
                </div>
            </div>
        </div>
    </form> --}}

    <div class="userlist mt-3 mx-3">
        <!-- single user list -->
        @forelse($allMessages as $thread)
        <div class="card single-userlist-card p-2 border-right-0 border-left-0 border-bottom-0">
            <div class="media">
                <div class="chat-wrapper mx-3 mt-1">
                    <span>{{ Str::title($thread->opponent->name[0]) }}</span>
                </div>
                <div class="media-body">
                    <h5 class="mt-0">
                        <a
                            href="{{ route('admin.chat',['slug'=>Crypt::encryptString($type.'-'.$user.'-'.$thread->opponent->type.'-'.$thread->opponent->id)]) }}">{{
                            Str::title($thread->opponent->name) }}</a>
                    </h5>
                    <p>{!! Str::limit($thread->message->message,50,'...') !!}</p>
                    <p>{{ $thread->unseen }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="border-0 card welcome-card">
            <div class="chat-wrapper mb-3 mx-auto">
                <span>{{ Str::title(auth()->user()->name[0]) }}</span>
            </div>
            <h4>Welcome, {{ Str::title(auth()->user()->name) }}</h4>
            <p>You did not have any conversation yet.</p>
        </div>
        @endforelse
        <!-- end single user list -->


    </div>
</main>
@endsection
