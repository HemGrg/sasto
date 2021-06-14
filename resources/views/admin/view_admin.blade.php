@extends('admin.layouts.master')

@section('content')

<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-product-hunt"></i>
               </div>
               <div class="header-title">
                  <h1>Admins</h1>
                  <small>Admin List</small>
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
              <div id="message_success" style="display: none;" class="alert alert-success">Status Enable</div>
              <div id="message_error" style="display: none;" class="alert alert-success">Status Disable</div>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4>View Admins</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
                        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                           <div class="btn-group">
                              <div class="buttonexport" id="buttonlist"> 
                                 <a class="btn btn-add" href="{{url('admin/add-admin')}}"> <i class="fa fa-plus"></i> Add Admin
                                 </a>  
                              </div>
                           </div>
                           <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                           <div class="table-responsive">
                              <table id="table_id" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">
                                       <th>Id</th>
                                       <th>Name</th>
                                       <th>email</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($adminDetail as $adminDetail)
                                    <tr>
                                    <td>{{$adminDetail->id}}</td>
                                       <td>{{$adminDetail->name}}</td>
                                       <td>{{$adminDetail->email}}</td>
                                    </tr>
                                   @endforeach
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