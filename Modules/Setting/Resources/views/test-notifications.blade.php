@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <x-alerts></x-alerts>
    <div class="ibox">
        <div class="ibox-head">
            <h4 class="h4-responsive py-4">{{ $title }}</h4>
        </div>
        <div class="ibox-body">
            <form action="{{ route('settings.notification.send-test-notification') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Send E-mail to:</label>
                    <input type="text" name="test_notification_email" class="form-control" value="{{ old('test_notification_email', auth()->user()->email) }}">
                </div>

                <div class="form-group">
                    <label for="">Send test SMS to:</label>
                    <input type="text" name="test_notification_sms_number" class="form-control" value="{{ old('test_notification_sms_number', auth()->user()->mobile) }}">
                </div>

                <button type="submit" class="btn btn-primary sm:px-16 sm:py-4">Send Now</button>
            </form>
        </div>
    </div>
</div>
@endsection
