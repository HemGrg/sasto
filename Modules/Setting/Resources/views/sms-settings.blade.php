@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <x-alerts></x-alerts>
    <div class="ibox">
        <div class="ibox-head">
            <h4 class="h4-responsive py-4">{{ $title }}</h4>
        </div>
        <div class="ibox-body">
            <form action="{{ route('settings.sms.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">SMS API token</label>
                    <input type="text" name="sms_api_token" class="form-control @error('sms_api_token') is-invalid @enderror" value="{{ old('sms_api_token', settings('sms_api_token')) }}">
                    <x-invalid-feedback field="sms_api_token"></x-invalid-feedback>
                </div>

                <div class="form-group">
                    <label for="">SMS Identity</label>
                    <input type="text" name="sms_identity" class="form-control @error('sms_identity') is-invalid @enderror" value="{{ old('sms_identity', settings('sms_identity')) }}">
                    <x-invalid-feedback field="sms_identity"></x-invalid-feedback>
                </div>

                <button type="submit" class="btn btn-primary sm:px-16 sm:py-4">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
