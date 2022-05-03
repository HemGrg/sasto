@extends('layouts.admin')

@section('page_title', 'Edit password')

@section('content')


<div class="page-content fade-in-up">
   <div class="row">
      <div class="col-md-12">
         <div class="ibox">
            <div class="ibox-head">
               <div class="ibox-title">Edit password</div>

               <div class="ibox-tools">
               </div>
            </div>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
               <ul>
                  @foreach($errors->all() as $error)
                  <li>{{$error}}</li>
                  @endforeach
               </ul>
            </div>
            @endif

            <div class="ibox-body" style="">
               <form method="post" action="{{route('admin.update_password', $detail->id)}}"
                  enctype="multipart/form-data">
                  @csrf

                  <div class="row">
                     <div class="form-group col-lg-6">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" value=""
                           placeholder="Enter Password">
                     </div>

                     <div class="form-group col-lg-6">
                        <label>Re-Password</label>
                        <input type="password" class="form-control" name="password_confirmation" value=""
                           placeholder="Enter Password Again">
                     </div>

                  </div>

                  <br>

                  <div class="form-group">
                     <button class="btn btn-default" type="submit">Submit</button>
                  </div>
               </form>
            </div>
         </div>
      </div>

   </div>



</div>

@endsection
@push('scripts')
@endpush