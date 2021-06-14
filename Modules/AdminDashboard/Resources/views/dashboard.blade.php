@extends('admindashboard::layouts.master')
@section('title','Sasto Wholesale Dashboard')
@section('content')
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper" id="app">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-dashboard"></i>
               </div>
               <div class="header-title">
                  <h1>Sasto Wholesale</h1>
                  <small>Very detailed & featured admin.</small>
               </div>
            </section>
            <!-- Main content -->
            <section class="content">
               <router-view></router-view>
            
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
@endsection
