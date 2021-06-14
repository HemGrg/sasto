@extends('admindashboard::layouts.master')
@section('title','Add Category')
@section('content')

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="header-icon">
         <i class="fa fa-list-alt"></i>
      </div>
      <div class="header-title">
         <h1>Add Category</h1>
         <small>Category list</small>
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
                  <form class="col-sm-12" action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                     {{csrf_field()}}
                     <div class="form-group col-sm-8">
                        <label>Category Name</label>
                        <input type="text" class="form-control" placeholder="Enter Category Name" name="name" id="name">
                     </div>
                     <div class="form-group col-sm-3">
                        <label>Upload Category Image</label>
                        <input type="file" name="image" id="fileUpload" class="form-control">
                        <div id="wrapper" class="mt-2">
                           <div id="image-holder">
                           </div>
                        </div>
                     </div>
                     <div class="form-group col-sm-10">
                        <label for="" class="col-sm-3">Is Featured Category ? :</label>
                        <div class="col-sm-1">
                           <label class="ui-checkbox">
                              <input type="checkbox" id="featured" name="featured" unchecked>
                              <span class="input-span"></span>Yes
                           </label>
                        </div>
                        <label class="col-lg-6">
                           <span class="alert-warning">
                              *Remembar: This will allow to display in 'Best Our Collections Section
                              in homepage.'
                           </span>
                        </label>
                     </div>
                     <div class="form-group col-sm-10">
                        <label for="" class="col-sm-3">Include in the menu ? :</label>
                        <div class="col-sm-1">
                           <label class="ui-checkbox">
                               <input type="checkbox" id="in_include" name="in_include" unchecked>
                              <span class="input-span"></span>Yes
                           </label>
                        </div>
                        <label class="col-lg-6">
                           <span class="alert-warning">*Remembar:Don't tick on this
                              menu if this is not a Top Menu Category.</span>
                        </label>
                     </div>
                     <div class="form-group col-sm-10">
                        <label for="" class="col-sm-3">Does Contains Sub-category ? :</label>
                        <div class="col-sm-1">
                           <label class="ui-checkbox">
                              <input type="checkbox" id="is_sub_category" name="is_sub_category" unchecked>
                              <span class="input-span"></span>Yes
                           </label>
                        </div>
                     </div>
                     <div class="form-group col-sm-10">
                        <label for="" class="col-sm-3">Publish ? :</label>
                        <div class="col-sm-1">
                           <label class="ui-checkbox">
                              <input type="checkbox" id="publish" name="publish" unchecked>
                              <span class="input-span"></span>Yes
                           </label>
                        </div>
                     </div>
                     <div class="reset-button col-sm-12">
                        <input type="submit" class="btn btn-success" value="Add Category">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- /.content -->
</div>

@endsection

@push('script')

@include('admindashboard::admin.layouts._partials.imagepreview')

@endpush