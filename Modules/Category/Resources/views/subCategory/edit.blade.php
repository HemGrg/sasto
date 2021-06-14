@extends('admindashboard::layouts.master')
@section('title','Edit Sub-category')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-list-alt"></i>
        </div>
        <div class="header-title">
            <h1>Edit Sub-category</h1>
            <small>Sub-category list</small>
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
                            <a class="btn btn-add " href="{{route('view-sub-categories',$parentCategory->slug)}}">
                                <i class="fa fa-eye"></i> View Categories</a>
                        </div>
                        <span style="font-weight: 700; margin-left: 10px;">Category Name : {{$parentCategory->name}}</span>
                    </div>

                    <div class="panel-body">
                        <form class="col-sm-12" action="{{route('edit-sub-category',$detail->slug)}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group col-sm-8">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{$detail->name}}" name="name" id="name">
                            </div>
                            <div class="form-group col-sm-3">
                                <label>Upload Category Image</label>
                                <input type="file" name="image" id="fileUpload" class="form-control">
                                <div id="image-holder">
                                    @if($detail->image)
                                    <img src="{{asset('uploads/subCategory/'. $detail->image)}}" style="margin-top:12px; margin-bottom:12px;" height="100px" width="120px" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-sm-10">
                                <label for="" class="col-sm-3">Is Featured Category ? :</label>
                                <div class="col-sm-1">
                                    <label class="ui-checkbox">
                                        <input type="checkbox" id="featured" name="featured" {{$detail->featured==1?'checked':''}}>
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
                                        <input type="checkbox" id="in_include" name="in_include" {{$detail->is_included_on_main_menu==1?'checked':''}}>
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
                                       <input type="checkbox" id="publish" name="publish" {{$detail->publish==1?'checked':''}}>
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