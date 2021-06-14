@extends('admin.layouts.master')
@section('content')
  
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-user"></i>
               </div>
               <div class="header-title">
                  <h1>Add New Admin</h1>
                  <small>Admin list</small>
               </div>
            </section>
            @if(Session::has('flash_message_error'))
              <div class="alert alert-sm alert-danger alert-block" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span area-hidden="true">&times;</span>
                </button>
                <strong>{!! session('flash_message_error') !!}</strong>
              </div>
              @endif

              @if(Session::has('flash_message_success'))
              <div class="alert alert-sm alert-success alert-block" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                </button>
                <strong>{!! session('flash_message_success') !!}</strong>
              </div>
              @endif
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonlist"> 
                              <a class="btn btn-add " href="{{url('admin/view-admins')}}"> 
                              <i class="fa fa-eye"></i> View Admins</a>  
                           </div>
                        </div>
                        <div class="panel-body">
                           <form class="col-sm-6" enctype="multipart/form-data" action="{{url('/admin/add-admin')}}" method="POST">
                           {{csrf_field()}}
                              <div class="form-group">
                                 <label>Name</label>
                                 <input type="text" class="form-control" placeholder="Enter Admin Name" name="admin_name" id="admin_name" required>
                              </div>
                              <div class="form-group">
                                 <label>Email</label>
                                 <input type="text" class="form-control" placeholder="Enter Admin Email" name="admin_email" id="admin_email" required>
                              </div>
                              <div class="form-group">
                                 <label>Password</label>
                                 <input type="password" class="form-control" placeholder="Enter Password" name="admin_password" id="admin_password" required>
                              </div> 
                              <div class="reset-button">
                                 <input type="submit" class="btn btn-success" value="Add Admin ">
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