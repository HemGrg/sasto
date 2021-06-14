@extends('admindashboard::layouts.master')
@section('title','site Setting')
@section('content')

<div class="content-wrapper">
   <section class="content-header">
      <div class="header-icon">
         <i class="fa fa-gear"></i>
      </div>
      <div class="header-title">
         <h1>Site Setting</h1>
      </div>
   </section>

   @include('admindashboard::admin.layouts._partials.messages.info')

   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- Form controls -->
         <div class="col-sm-12">
            <form class="col-sm-12" enctype="multipart/form-data" action="{{route('site-setting.update',$detail->id)}}" method="POST">
               {{csrf_field()}}
               <input type="hidden" name="_method" value="PUT">
               <div class="panel panel-bd lobidrag col-sm-12">
                  <div class="panel-body col-sm-6">
                     <h2 style="margin-top: 2px; font-size: 20px; font-weight:700;">
                        Company Details</h2>
                     <hr style="margin-top: 0px;">
                     <div class="form-group">
                        <label>Company Name:</label>
                        <input type="text" class="form-control" value="{{$detail->company_name}}" name="company_name" id="company_name">
                     </div>
                     <div class="form-group">
                        <label>Slogan:</label>
                        <input type="text" class="form-control" value="{{$detail->slogan}}" name="slogan" id="slogan" required>
                     </div>
                     <div class="form-group">
                        <label>Address:</label>
                        <input type="text" class="form-control" value="{{$detail->address}}" name="address" id="address" required>
                     </div>
                     <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" class="form-control" value="{{$detail->phone}}" name="phone" id="phone" required>
                     </div>
                     <div class="form-group">
                        <label>Whatsapp:</label>
                        <input type="text" class="form-control" value="{{$detail->whatsapp}}" name="whatsapp" id="whatsapp" required>
                     </div>
                     <div class="form-group">
                        <label>Viber:</label>
                        <input type="text" class="form-control" value="{{$detail->viber}}" name="viber" id="viber" required>
                     </div>
                     <div class="form-group">
                        <label>Meta Title:</label>
                        <input type="text" class="form-control" value="{{$detail->meta_title}}" name="meta_title" id="meta_title" required>
                     </div>
                     <div class="form-group">
                        <label>Meta Description:</label>
                        <textarea class="form-control" name="meta_description">{!! $detail->meta_description !!}
									</textarea>
                     </div>
                  </div>
                  <div class="panel-body col-sm-6">
                     <h2 style="margin-top: 2px; font-size: 20px; font-weight:700;">Social Media Links</h2>
                     <hr style="margin-top: 0px;">
                     <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" class="form-control" value="{{$detail->facebook}}" name="facebook" id="facebook" required>
                     </div>
                     <div class="form-group">
                        <label>Twiter</label>
                        <input type="text" class="form-control" value="{{$detail->twiter}}" name="twiter" id="twiter" required>
                     </div>
                     <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" class="form-control" value="{{$detail->instagram}}" name="instagram" id="instagram" required>
                     </div>
                     <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{$detail->email}}" name="email" id="email" required>
                     </div>
                     <h2 style="margin-top: 2px; font-size: 20px; font-weight:700;">Upload Images</h2>
                     <hr style="margin-top: 0px;">
                     <div class="form-group">
                        <label>Upload Logo</label>
                        <input id="fileUpload" type="file" name="logo" class="form-control">
                        <div id="wrapper" class="mt-2">
                           <div id="image-holder1">
                              @if($detail->logo)
                              <img src="{{asset('uploads/sitesetting/'. $detail->logo)}}" style="margin-top:12px; margin-bottom:12px;" height="100px" width="120px" alt="">
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Upload Favicon</label>
                        <input id="fileUpload" type="file" name="fav_icon" class="form-control">
                        <div id="wrapper" class="mt-2">
                           <div id="image-holder1">
                              @if($detail->fav_icon)
                              <img src="{{asset('uploads/sitesetting/'. $detail->fav_icon)}}" style="margin-top:12px; margin-bottom:12px;" height="100px" width="120px" alt="">
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="reset-button">
                        <input type="submit" class="btn btn-success" value="Update Site Setting">
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
</div>
</section>
<!-- /.content -->
</div>

@endsection
