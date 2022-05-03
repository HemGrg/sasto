@extends('layouts.admin')
@section('page_title', 'Edit subscriber')
@section('content')

@include('admin.section.notifications')
<div class="page-content fade-in-up">
   <div class="ibox">
      <div class="ibox-head">
         <div class="ibox-title">Edit subscriber</div>
         <div>
            <a class="btn btn-info btn-md" href="{{route('subscriber.index')}}">All subscriber List</a>
         </div>
      </div>
   </div>

   <form class="form form-responsive form-horizontal" action="{{route('subscriber.update', $detail->id)}}"
      enctype="multipart/form-data" method="post">
      <input type="hidden" name="_method" value="PUT">
      {{csrf_field()}}
      <div class="row">
         <div class="col-lg-12">
            <div class="row">
               <div class="col-lg-9 col-md-9 col-12">
                  <div class="ibox">
                     <div class="ibox-head">
                        <div class="ibox-title">Subscriber Information</div>
                        <div class="ibox-tools">
                           {{--
                                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                                    --}}
                           {{--dd($slider_info)--}}
                        </div>
                     </div>
                     <div class="ibox-body">

                        <div class="row">
                           <div class="col-lg-12 col-sm-12 form-group">
                              <label>Email</label>
                              <input class="form-control" type="text" disabled value="{{$detail->email}}" name="title">
                              @if($errors->has('title'))
                              <span class=" alert-danger">{{$errors->first('email')}}</span>
                              @endif
                           </div>
                           <div class="col-12 form-group">
                              <label class="ui-checkbox ui-checkbox-primary" style="margin-top: 35px;">
                                 <input type="checkbox" name="status"
                                    {{((@$detail->status == 'publish') ? 'checked' : '')}}>
                                 <span class="input-span"></span><strong>status</strong>
                              </label>
                           </div>
                        </div>
                        <div class="form-group">
                           <button class="btn btn-success" type="submit"> <span class="fa fa-send"></span>
                              Save</button>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </form>

</div>

@endsection
@section('scripts')

@endsection