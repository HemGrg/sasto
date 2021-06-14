@extends('admindashboard::layouts.master')
@section('title','View Sub Categories')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-shopping-basket"></i>
        </div>
        <div class="header-title">
            <h1>View Sub Categories</h1>
            <small>Sub Category List</small>
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
                                <a class="btn btn-add" href="{{route('add-sub-category',$parentCategory->slug)}}"> <i class="fa fa-plus"></i> Add Sub-Category
                                </a>
                            </div>
                        </div>
                        <span style="font-weight: 700; margin-left: 10px;">Category Name : {{$parentCategory->name}}</span>
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
                                        <td>{{$detail->is_included_on_main_menu==1? 'Yes':'No'}}</td>
                                        <td>{{$detail->publish==1? 'Yes':'No'}}</td>
                                        <td>
                                            @if(!empty($detail->image))
                                            <img src="{{asset('uploads/subCategory/'.$detail->image)}}" alt="" style="width: 100px; height:100px;">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('edit-sub-category',$detail->slug)}}" class="btn btn-add btn-sm" title="Edit Sub-Category">Edit</a>
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