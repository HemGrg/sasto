@extends('layouts.admin')
@section('page_title') All Slider @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All sliders</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('slider.create')}}">New Slider</a>
            </div>
        </div>

        <div class="ibox-body">
            <table class="table table-striped table-responsive-sm table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($sliders->count())
                    @foreach($sliders as $key => $slider_data)
                    <tr class="category_row{{$slider_data->id}}">
                        <td> {{$key +1}}</td>
                        <td>
                            @if(isset($slider_data->image) && !empty($slider_data->image) && file_exists(public_path().'/images/thumbnail/'.$slider_data->image))
                            <img src="{{asset('/images/thumbnail/'.$slider_data->image)}}" alt="No Image" class=" img img-thumbnail  img-sm rounded" style="max-width: 150px;">
                            @endif
                        </td>

                        <td class="text-capitalize"> {{$slider_data->title}}</td>
                        <td>{{$slider_data->description}}</td>
                        <td> {{$slider_data->status}}</td>
                        <td>
                            <div class="d-flex" style="gap: 1rem;">
                                <a href="{{route('slider.edit', $slider_data->id)}}" class="btn btn-primary border-0"><i class="fa fa-edit"></i> Edit</a>
                                <div class="mx-2"></div>
                                <form action="{{ route('slider.destroy', $slider_data->id) }}" class="js-delete-slider-form form-inline d-inline" method="post">
                                    @csrf()
                                    @method('DELETE')
                                    <button class="btn btn-danger border-0">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any sliders yet.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
            "aoColumnDefs": [{
                "bSortable": false
                , "aTargets": [-1, -2]
            }]
        });
        $(document).ready(function() {
            // Confirm before delete
            $('.js-delete-slider-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?'
                    , text: `You Want to delete this Slider??`
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Yes, Delete it!'
                }).then((result) => {
                    if (result.value) {
                        e.target.submit();
                    } else {
                        $(this).find('button[type="submit"]').prop('disabled', false);
                    }
                })
            });
        });
    })

</script>
<script>
    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message + '</p>';
        });
        Swal.fire({
            type: 'error'
            , title: 'Oops...'
            , html: html_error
            , confirmButtonText: 'Close'
            , timer: 10000
        });
    }

    function DataSuccessInDatabase(message) {
        Swal.fire({
            position: 'top-end'
            , type: 'success'
            , title: 'Done'
            , html: message
            , confirmButtonText: 'Close'
            , timer: 10000
            , toast: true
        });
    }

</script>
@endsection
