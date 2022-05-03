<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') Brand View @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Brand Details</div>

          <div class="ibox-tools">

          </div>
        </div>

		<div class="ibox-body" style="">
		<table class="table">
  <thead>
    <tr>
      <th scope="col">Brand</th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Title</th>
      <td><span id="title"></span></td>
    </tr>
	<tr>
      <th scope="row">Slug</th>
      <td><div id="slug"></div></td>
    </tr>
	<tr>
      <th scope="row">Publish</th>
	  <td><span id="publish"></span><span style="margin-left: 30px;" id="publish"></td>
    </tr> 
    
    
  </tbody>
</table>


		</div>
      </div>
    </div>

  </div>



</div>
            @endsection
    @section('scripts')
    <script> 
    $(document).ready(function(){
		var id = <?php echo $id; ?>;
    var api_token = '<?php echo $api_token; ?>';
            function viewbrand(id){
                $.ajax({ 
           type: "get", 
           url:"/api/view-brand", 
           data:{id:id},
           headers: {
            Authorization: "Bearer " + api_token
        },
           success: function(response) {
               document.getElementById('title').innerHTML = response.data.title;
               document.getElementById('slug').innerHTML = response.data.slug;
			   if(response.data.publish == '1'){
						document.getElementById('publish').innerHTML = '<span class="label label-success">Published</span>';
					}
					else if(response.data.publish == '0'){
						document.getElementById('publish').innerHTML = '<span class="label label-danger">Unpublished</span>';
					}            
           }
       });
            }
			viewbrand(id);
          });


	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
            </script>

    @endsection


       
 
 

            