@extends('admindashboard::layouts.master')
@section('title','Add Sub-Category')
@section('content')

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="header-icon">
         <i class="fa fa-list-alt"></i>
      </div>
      <div class="header-title">
         <h1>Add Sub-Category</h1>
         <small>Sub-Category list</small>
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
                     <a class="btn btn-add " href="{{route('view-sub-categories',$detail->slug)}}">
                        <i class="fa fa-eye"></i> View Sub-Categories</a>
                  </div>
                  <span style="font-weight: 700; margin-left: 10px;">Category Name : {{$detail->name}}</span>
               </div>

               <div class="panel-body">
                  <form class="col-sm-12" action="{{route('add-sub-category',$detail->id)}}" method="POST" enctype="multipart/form-data">
                     {{csrf_field()}}
                     <input type="hidden" name="category_slug" value="{{$detail->slug}}">
                     <input type="hidden" name="parent_id" value="{{$detail->id}}">
                    
                     <div class="form-group col-sm-8">
                        <label>Sub Category Name</label>
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