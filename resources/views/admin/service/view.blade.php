@extends('admindashboard::layouts.master')
@section('title','View Serivces')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-shopping-basket"></i>
        </div>
        <div class="header-title">
            <h1>View Services</h1>
            <small>Service List</small>
        </div>
    </section>
    <!-- Main content -->
   <div id="app">
   <view-service></view-service>
   </div>
    <!-- /.content -->
</div>
<script src="{{asset('js/app.js')}}"></script>
@endsection
@push('script')

@endpush