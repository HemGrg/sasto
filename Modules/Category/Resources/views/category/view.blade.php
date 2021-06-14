@extends('admindashboard::layouts.master')
@section('title','View Category')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-shopping-basket"></i>
        </div>
        <div class="header-title">
            <h1>View Categories</h1>
            <small>Category List</small>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
    @include('admindashboard::admin.layouts._partials.messages.info')
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="btn-group">
                            <div class="buttonexport" id="buttonlist">
                                <a class="btn btn-add" href="{{route('category.create')}}"> <i class="fa fa-plus"></i> Add Category
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                    <div class="table-responsive">
                            <table id="table_id" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="info">
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Is Featured?</th>
                                        <th>Is Include In Main Menu?</th>
                                        <th>Does Contains Sub-Categories?</th>
                                        <th>Is Publish?</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($details->count())
                                    @foreach($details as $key=>$detail)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$detail->name}}</td>
                                        <td>{{$detail->featured==1? 'Yes':'No'}}</td>
                                        <td>{{$detail->include_in_main_menu==1? 'Yes':'No'}}</td>
                                        <td>{{$detail->does_contain_sub_category==1? 'Yes':'No'}}</td>
                                        <td>{{$detail->publish==1? 'Yes':'No'}}</td>
                                        <td>
                                            @if(!empty($detail->image))
                                            <img src="{{asset('uploads/category/'.$detail->image)}}" alt="" style="width: 100px; height:100px;">
                                            @endif
                                        </td>
                                        <td>
                                            
                                            <a href="{{route('add-sub-category',$detail->slug)}}" class="btn btn-warning btn-sm" title="Add Sub-Category">Add Sub-Cat</a>
                                            <a href="{{route('view-sub-categories',$detail->slug)}}" class="btn btn-warning btn-sm" title="View Sub-Categories">View Sub-cat</a>
                                            <a href="{{route('category.edit',$detail->slug)}}" class="btn btn-add btn-sm" title="Edit Category">Edit</a>
                                            <form method="post" action="{{route('category.destroy',$detail->id)}}" class="delete">
                                                {{csrf_field()}}

                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn  btn-danger btn-delete" style="display:inline" title="Delete Service"><i class="fa fa-trash-o"></i> </a></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('script')

@endpush