@extends('layouts.admin')
@section('page_title','Chat')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/chat.css') }}">
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
@endsection
@section('content')
<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div class="chat">
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="chat-wrapper mx-1 mt-1">
                                <span>{{ Str::title($opponentType=="vendor"?$opponent->shop_name[0]:$opponent->name[0])
                                    }}</span>
                            </div>
                            <div class="chat-about">
                                <h6 class="mb-0">{{
                                    Str::title($opponentType=="vendor"?$opponent->shop_name:$opponent->name)}}</h6>

                            </div>
                        </div>
                    </div>
                    <div class="chat-history" id="messageBody">
                        <ul class="m-b-0 overflow-auto" id="chat-message">
                            @foreach($formatMessages as $message)
                            <li class="clearfix">
                                <div
                                    class="message {{ $message->type=='opponent'?'other-message':'my-message float-right'}} ">
                                    {{ $message->message }}</div>
                            </li>

                            @endforeach

                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <input type="text" class="form-control" id="message-input" placeholder="Enter text here...">
                            <div class="input-group-prepend" id="send" style="padding: 10px;background:lightgrey;}">
                                <span class="input-group-text"><i class="fa fa-send"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var messageBody = document.querySelector('#messageBody');
    messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

    function scrollToLatest(){
        var messageBody = document.querySelector('#messageBody');
        messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
    }
    Pusher.logToConsole = true;
    var pusher = new Pusher('cbe0b7b8904e2ede8292', {
      authEndpoint: "/pusher/auth",
      auth : {
        headers:{
            "X-CSRF-Token":"{{ csrf_token() }}",
            "accept":"application/json"
        },
      },
      cluster: 'ap2'
    });
    var selfId = "{{ $user }}";
    var channel = pusher.subscribe("private-Message{{ $channelName }}");
    channel.bind('message-event', function(data) {
        if(selfId==data.selfId){
            // $("#chat-message").append(`
            // <li class="clearfix">
            //     <div class="message my-message float-right " }} ">
            //                 ${data.message}
            //             </div>
            //         </li>
            //         `);
        }else{
            $("#chat-message").append(`
            <li class="clearfix">
                <div class="message other-message" }} ">
                            ${data.message}
                        </div>
            </li>
            `);
        }

        scrollToLatest();
    });
</script>
@endsection
@push('push_scripts')
<script>
    $('#send').on('click',function(e){
       e.preventDefault();
       let messageInput = $('#message-input').val();
       if(!messageInput && messageInput==undefined){
           return;
       }
       $('#message-input').val("");
       $.ajax({
           url: "{{ route('admin.message.store') }}",
           type:"POST",
           data:{
                "_token": "{{ csrf_token() }}",
                "from":"{{ $user }}",
                "from_type":"{{ $type }}",
                "to_type":"{{ $opponentType }}",
                "to":"{{ $opponent->id }}",
                "message":messageInput,
            },
            success:function(response){

                $("#chat-message").append(`
                    <li class="clearfix">
                        <div class="message my-message float-right" }} ">
                            ${messageInput}
                        </div>
                    </li>
                       `);
                scrollToLatest();
            },
            error:function(error){

            }
       });

    });
</script>
@endpush
