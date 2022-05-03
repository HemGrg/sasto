<?php
$user = Auth::user();
$api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('styles')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
@endsection

@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Create Deal</div>
                    <div>
                        <a href="{{ route('deals.index') }}" class="btn btn-primary">Back to listing</a>
                    </div>
                </div>
 
                <div class="ibox-body" id="validation-errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </div>
                <div id="app">
                    {{-- @dd($customer) --}}
                    <createdeal auth={{Auth::id()}} :products="{{ json_encode($products) }}" :prop-customer="{{ $customer }}"/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('push_scripts')
<script src="{{mix('js/app.js')}}"></script>
@endpush