@extends('layouts.admin')
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Reviews</div>
        </div>
        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-responsive-sm table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full name</th>
                        <th>Rate</th>
                        <th>Review</th>
                        <th>Product</th>
                        <th>Change Status</th>
                    </tr>
                </thead>
                <tbody>

                    @if($reviews->count())
                    @foreach($reviews as $key => $data)

                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->rate}}</td>
                        <td>{{$data->reviews}}</td>
                        <td>{{$data->product->title}}</td>
                        <td>
                            <input type="checkbox" id="toggle-event" data-toggle="toggle" class="ReviewStatus btn btn-success btn-sm"  rel="{{$data->id}}"
                             data-on="Publish" data-off="Unpublish" data-onstyle="success" data-offstyle="danger" data-size="mini"
                            @if($data->status == 'publish') checked @endif>
                        </td>
                        
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any data yet.
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
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>
<script>
    function FailedResponseFromDatabase(message){
    html_error = "";
    $.each(message, function(index, message){
        html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> '+message+ '</p>';
    });
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        html:html_error ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}
function DataSuccessInDatabase(message){
    Swal.fire({
        // position: 'top-end',
        type: 'success',
        title: 'Done',
        html: message ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}
</script>
<script>
  $(function() {
    $('#toggle-event').change(function() {
        var review_id = $(this).attr('rel');
        if($(this).prop("checked")==true){
            $.ajax({
                method:"POST",
                url : '/api/reviews/'+ review_id +'/publish',
                data : {
                _method: "put"
                },
                success : function(response){
                    if (response.status == 'false' ) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == 'true') {
                        DataSuccessInDatabase(response.message);
                    }
                }
            });
        }else{
                $.ajax({
                    method:"POST",
                    url : '/api/reviews/'+ review_id +'/unpublish',
                    data : {
                        _method: "delete"
                    },
                    success : function(response){
                        if (response.status == 'false' ) {
                            FailedResponseFromDatabase(response.message);
                        }
                        if (response.status == 'true') {
                            DataSuccessInDatabase(response.message);
                        }
                    }
                });
            }
    })
  })
</script>

<script>
//       //Review publish/unpublish
// $(".ReviewStatus").change(function(){
//     var review_id = $(this).attr('rel');
//         if($(this).prop("checked")==true){
//             $.ajax({
//                 method:"POST",
//                 url : '/api/reviews/'+ review_id +'/publish',
//                 data : {
//                 _method: "put"
//                 },
//                 success : function(response){
//                     if (response.status == 'false' ) {
//                         FailedResponseFromDatabase(response.message);
//                     }
//                     if (response.status == 'true') {
//                         DataSuccessInDatabase(response.message);
//                     }
//                 }
//             });
//         }else{
//                 $.ajax({
//                     method:"POST",
//                     url : '/api/reviews/'+ review_id +'/unpublish',
//                     data : {
//                         _method: "delete"
//                     },
//                     success : function(response){
//                         if (response.status == 'false' ) {
//                             FailedResponseFromDatabase(response.message);
//                         }
//                         if (response.status == 'true') {
//                             DataSuccessInDatabase(response.message);
//                         }
//                     }
//                 });
//             }
// });
</script>

@endsection