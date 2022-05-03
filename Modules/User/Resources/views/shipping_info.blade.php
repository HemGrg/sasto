@extends('layouts.admin')
@section('page_title'){{ ucfirst(auth()->user()->vendor->shop_name) }} Shipping Info @endsection

@section('content')
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            <form action="{{ $updateMode ? route('getShippingInfo.update', $auth()->user()->vendor->id) : route('updateShippingInfo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($updateMode)
                @method('PUT')
                @endif
                <div class="col-lg-12 col-sm-12 form-group">
                    <div style="text-align: center;"  >
                        <label><strong><h4 style="font-weight: bold;">Shipping And Return Policy</h4></strong></label>
                    </div>
                    <textarea name="shipping_info" id="shipping_info" rows="5" placeholder="Shipping Info Here" class="form-control" style="resize: none;">{{ auth()->user()->vendor->shipping_info }}</textarea>
                </div>
                <div class="col-lg-12 col-sm-12 form-group">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
<?php
$name = ['shipping_info'];
?>
@push('push_scripts')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
@foreach ($name as $data)
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach
@endpush