@extends('layouts.admin')
@section('page_title')Edit Vendor Info @endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
@include('admin.section.notifications')
@if($errors->any())
<div class="alert alert-danger">
    <p><strong>Opps Something went wrong</strong></p>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title"> Edit Profile <span style="font-weight: 100;">({{$user->vendor->shop_name}})</span></div>
        </div>
    </div>
    <div class="ibox">
        
        <x-profile></x-profile>
        
        <div class="tab-content" id="component-1-content">
            <div class="tab-pane fade show active" id="component-1-1" role="tabpanel" aria-labelledby="component-1-1">

                <form method="post" action="{{route('vendor.updateVendorDetails',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    <div class="ibox-body">
                        <div class="card border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Shop Name</strong> </label>
                                        <input class="form-control" type="text" value="{{$user->vendor->shop_name}}" name="shop_name" placeholder="Enter Shop Name Here">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label><strong>Update Profile Image</strong> </label>
                                        <div id="wrapper" class="py-2">
                                            <div id="image-holder">
                                                {{-- @if($user->vendor->image)
                                                <img src="{{ asset('images/listing/'.$user->vendor->image) }}" alt="No Image" id="picture" class="rounded">
                                                @else  --}}
                                                <img src="https://dummyimage.com/800x800/e8e8e8/0011ff" name="pic" id="picture" style="max-height: 250px;">
                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                        <input id="fileUpload" class="form-control-file" value="" name="image" type="file">
                                    </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Company Email</strong> </label>
                                        <input class="form-control" type="text" value="{{$user->vendor->company_email}}" name="company_email" placeholder="Enter Company Email Here">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Company Address</strong> </label>
                                        <input class="form-control" type="text" value="{{$user->vendor->company_address}}" name="company_address" placeholder="Enter Company Address Here">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Phone Number</strong> </label>
                                        <input class="form-control" type="text" value="{{$user->vendor->phone_number}}" name="phone_number" placeholder="Enter Phone Number Here">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="country_id">Country: </label>
                                        <select class="custom-select select_group" id="country_id" name="country_id" style="width: 100%">
                                            @foreach($countries as $item)
                                            <option value="{{$item->id}}" @if ($user->vendor->country_id==$item->id){{"selected"}} @endif>
                                                {{$item->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="business_type">Business Type: </label>
                                        <select class="custom-select select_group" id="business_type" name="business_type" style="width: 100%">
                                            @foreach(config('constants.business_type') as $item)
                                            <option value="{{$item}}" @if ($user->vendor->business_type==$item){{"selected"}} @endif>
                                                {{ucfirst($item)}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="plan">Plan: </label>
                                        <select class="custom-select select_group" id="plan" name="plan" style="width: 100%">
                                            <option value="standard_plan" @if ($user->vendor->plan=="standard_plan"){{"selected"}} @endif>Standard Plan </option>
                                            <option value="premium_plan" @if ($user->vendor->plan=="premium_plan"){{"selected"}} @endif>Premium Plan </option>
                                            <option value="basic_plan" @if ($user->vendor->plan=="basic_plan"){{"selected"}} @endif>Basic Plan </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="category">Select Category: </label>
                                        <select class="custom-select select_group" id="category" name="category" style="width: 100%">
                                            <option value="local_seller" @if ($user->vendor->category=="local_seller"){{"selected"}} @endif>Local Seller </option>
                                            <option value="international_seller" @if ($user->vendor->category=="international_seller"){{"selected"}} @endif>International Seller </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label for="category_id">What Type of product do you sell ? </label><span> (multiple select)</span>
                                        <select class="form-control select_group" id="category_id" name="category_id[]" multiple style="width: 100%">
                                            @foreach ($categories->toArray() as $item)
                                            <option value="{{$item['id']}}" {{($user->vendor->categories->where('name',$item['name'])->count()==0)?'':'selected'}}>{{ $item['name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success "><i class="fa-solid fa-paper-plane"></i> Update Profile</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="tab-pane fade" id="component-1-2" role="tabpanel" aria-labelledby="component-1-2">
                <form method="post" action="{{route('vendor.updateVendorDescription',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 form-group">
                                <label><strong>Description</strong></label>
                                <textarea name="description" id="description" rows="5" placeholder="description Here" class="form-control" style="resize: none;">{{@$user->vendor->description}} </textarea>
                            </div>

                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success "><i class="fa-solid fa-paper-plane"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="component-1-3" role="tabpanel" aria-labelledby="component-1-3">
                <form method="post" action="{{route('vendor.updateUserDesc',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Name</strong> </label>
                                <input class="form-control" type="text" value="{{$user->name}}" name="name" placeholder="Enter Name Here">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Email</strong> </label>
                                <input class="form-control" type="text" value="{{$user->email}}" name="email" placeholder="Enter your Email Address">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Designation</strong></label>
                                <input class="form-control" type="text" value="{{$user->designation}}" name="designation" placeholder="Enter your Designation Here">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Contact Number</strong></label>
                                <input class="form-control" type="text" value="{{$user->phone_num}}" name="phone_num" placeholder="Enter your Phone Number">
                            </div>
                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success "><i class="fa-solid fa-paper-plane"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="component-1-4" role="tabpanel" aria-labelledby="component-1-4">
                <form method="post" action="{{route('vendor.updateVendorBankDetails',$user->vendor->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Bank Name </strong></label>
                                <input class="form-control" type="text" value="{{$user->vendor->bank_name}}" name="bank_name" placeholder="Enter Bank Name Here">
                            </div>

                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Branch Name </strong></label>
                                <input class="form-control" type="text" value="{{$user->vendor->branch_name}}" name="branch_name" placeholder="Enter Branch Name Here">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong>Account Number </strong> </label>
                                <input class="form-control" type="text" value="{{$user->vendor->account_number}}" name="account_number" placeholder="Enter your Account Number">
                            </div>
                            <div class="col-lg-8 col-sm-12 form-group">
                                <label><strong> Account Holder's Name</strong></label>
                                <input class="form-control" type="text" value="{{$user->vendor->name_on_bank_acc}}" name="name_on_bank_acc" placeholder="Enter your Name on Bank Account">
                            </div>
                            <div class="col-md-5">
                                <label><strong> Upload Image </strong> </label>
                                <input id="imageUpload" class="form-control-file" name="bank_info_image" type="file">
                                <div id="wrapper" class="py-2">
                                    <div id="bank-info-image-holder">
                                        @if($user->vendor->bank_info_image)
                                        <img src="{{asset('images/listing/'.$user->vendor->bank_info_image)}}" alt="No Image" class="rounded">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success px-4 border-0 "><i class="fa-solid fa-paper-plane"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="component-1-5" role="tabpanel" aria-labelledby="component-1-5">
                <form method="post" action="{{route('vendor.updateShippingInfo',$user->vendor->id)}}">
                    @csrf
                    @method('post')
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 form-group">
                                <!-- <label><strong>Shipping And Return Policy</strong></label> -->
                                <textarea name="shipping_info" id="shipping_info" rows="5" placeholder="shipping_info Here" class="form-control" style="resize: none;">{{@$user->vendor->shipping_info}} </textarea>
                            </div>

                            <div class="col-lg-12 col-sm-12 form-group">
                                <button type="submit" class="btn btn-success "><i class="fa-solid fa-paper-plane"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<?php
$name = ['description','shipping_info'];
?>
@push('push_scripts')
@include('dashboard::admin.layouts._partials.imagepreview')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
@foreach ($name as $data)
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category_id').select2();
    });
</script>
<script>
$(function() {
$('#picture').on('click', function() {
    $('#fileUpload').trigger('click');
});
});
</script>
<script>
    $(document).ready(function() {

        $("#imageUpload").on('change', function() {

            if (typeof(FileReader) != "undefined") {

                var image_holder = $("#bank-info-image-holder");

                $("#bank-info-image-holder").children().remove();

                var reader = new FileReader();
                reader.onload = function(e) {

                    $("<img />", {
                        "src": e.target.result,
                        "class": "thumb-image",
                        "width": '100%',
                        "height": '50%'
                    }).appendTo(image_holder);

                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[0]);
            } else {
                alert("This browser does not support FileReader.");
            }
        });

    });
</script>
@endpush