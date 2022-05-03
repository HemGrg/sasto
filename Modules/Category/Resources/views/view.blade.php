@extends('layouts.admin')
@section('page_title') Category Details @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Category Details</div>

          <div class="ibox-tools">

          </div>
        </div>

        <div class="ibox-body" style="">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Category</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Name</th>
                <td><span id="name"></span></td>
              </tr>
              <tr>
                <th scope="row">Slug</th>
                <td>
                  <div id="slug"></div>
                </td>
              </tr>
              <tr>
                <th scope="row">Image</th>
                <td>
                  <div id="image"></div>
                </td>
              </tr>
              <tr>
                <th scope="row">Include on main menu</th>
                <td>
                  <div id="include_in_main_menu"></div>
                </td>
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
  $(document).ready(function() {
    var id = <?php echo $id; ?>;

    function viewrole(id) {
      $.ajax({
        type: "get",
        url: "/api/view-category",
        data: {
          id: id
        },
        success: function(response) {
          document.getElementById('name').innerHTML = response.data.name;
          document.getElementById('slug').innerHTML = response.data.slug;
          if (response.data.publish == '1') {
            document.getElementById('publish').innerHTML = '<span class="label label-success">Published</span>';
          } else if (response.data.publish == '0') {
            document.getElementById('publish').innerHTML = '<span class="label label-danger">Unpublished</span>';
          }
          if (response.data.include_in_main_menu == '1') {
            document.getElementById('include_in_main_menu').innerHTML = '<span class="label label-success">Yes</span>';
          } else if (response.data.include_in_main_menu == '0') {
            document.getElementById('include_in_main_menu').innerHTML = '<span class="label label-danger">No</span>';
          }
          document.getElementById('image').innerHTML = '<img width="150" height="150" src="<?php echo URL::to('/') . '/images/thumbnail/'; ?>' + response.data.image + '">';
        }
      });
    }
    viewrole(id);
  });
</script>

@endsection