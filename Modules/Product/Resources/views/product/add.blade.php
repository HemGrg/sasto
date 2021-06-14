@extends('admindashboard::layouts.master')
@section('title','Add Product')
@section('content')

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="header-icon">
         <i class="fa fa-list-alt"></i>
      </div>
      <div class="header-title">
         <h1>Add Product</h1>
         <small>Product list</small>
      </div>
   </section>

  
   <!-- Main content -->
   <section class="content">
      <div class="row">
      @include('admindashboard::admin.layouts._partials.messages.info')
         <!-- Form controls -->
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
               <div class="panel-heading">
                  <div class="btn-group" id="buttonlist">
                     <a class="btn btn-add " href="{{route('category.index')}}">
                        <i class="fa fa-eye"></i> View Categories</a>
                  </div>
               </div>

               <div class="panel-body">
                 <div id="app">
                 <add-product></add-product>
                 </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- /.content -->
</div>
<script src="{{asset('js/app.js')}}"></script>
@endsection

@push('script')

@include('admindashboard::admin.layouts._partials.imagepreview')

@endpush