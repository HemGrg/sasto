@extends('layouts.admin')
@section('page_title'){{ ucfirst($vendor->vendor->shop_name) }} Profile @endsection

@section('content')
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ucfirst($vendor->vendor->shop_name) }}</div>
        </div>
    </div>
    <div class="ibox">
        <x-profile></x-profile>
        <!-- <div class="ibox-head">
            <ul class="plain-nav-tabs nav nav-tabs lavalamp" id="component-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#component-1-1" role="tab" aria-controls="component-1-1" aria-selected="true"><strong>Business Information</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#component-1-2" role="tab" aria-controls="component-1-2" aria-selected="false"><strong>About Company </strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#component-1-3" role="tab" aria-controls="component-1-3" aria-selected="false"><strong>User Information </strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#component-1-4" role="tab" aria-controls="component-1-4" aria-selected="false"><strong>Bank Details </strong></a>
                </li>
            </ul>
        </div> -->
        <div class="tab-content" id="component-1-content">
            <div class="tab-pane fade show active" id="component-1-1" role="tabpanel" aria-labelledby="component-1-1">

                <div class="ibox-body">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div id="wrapper" class="mt-2">
                                        <div id="image-holder">
                                            <img class="rounded img-responsive" src="{{ $vendor->vendor->imageUrl() }}" alt="No Image" style="max-width: 200px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <label class="title-label">Category</label>
                                            <div class="text-capitalize">{{ Str::replace('_', ' ', $vendor->vendor->category) }}</div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="title-label">Email</label>
                                            <div>{{ $vendor->vendor->company_email }}</div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="title-label">Address</label>
                                            <div>{{ $vendor->vendor->company_address }}</div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="title-label">Country</label>
                                            <div>{{ $vendor->vendor->country->name }}</div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="title-label">Plan</label>
                                            <div class="text-capitalize">{{ Str::replace('_', ' ', $vendor->vendor->plan) }}</div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="title-label">Phone</label>
                                            <div>{{ $vendor->vendor->phone_number }}</div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="title-label">Status</label>
                                            <div>{{ ucfirst($vendor->vendor_type) }}</div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="title-label">Business Type</label>
                                            <div>{{ ucfirst($vendor->vendor->business_type) }}</div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label class="title-label">Type of Product</label>
                                            <div>
                                                @foreach($vendor->vendor->categories as $cat)
                                                {{ $cat->name }}
                                                @if(!$loop->last)
                                                <span>,</span>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="component-1-2" role="tabpanel" aria-labelledby="component-1-2">

                <div class="ibox-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 form-group">
                            {!! $vendor->vendor->description !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="component-1-3" role="tabpanel" aria-labelledby="component-1-3">
                <div class="ibox-body">
                    <div class="card profile-card border-0 bg-transparent">
                        <div class="card-body">
                            <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                            <h4 class="profile-card-subtitle"><strong>Name:</strong> {{ucfirst($vendor->name)}}</h4>
                            <h4 class="profile-card-subtitle"><strong>Email:</strong>{{$vendor->email}}</h4>
                            <h4 class="profile-card-subtitle"><strong>Designation:</strong> {{$vendor->designation}}</h4>
                            <h4 class="profile-card-subtitle"><strong>Contact Number:</strong> {{$vendor->phone_num}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="component-1-4" role="tabpanel" aria-labelledby="component-1-4">
                <div class="ibox-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card profile-card border-0 bg-transparent">
                                <div class="card-body">
                                    <h3 class="profile-card-title">{{ucfirst($vendor->vendor->shop_name)}}</h3>
                                    <h4 class="profile-card-subtitle"><strong>Bank Name:</strong> {{$vendor->vendor->bank_name}}</h4>
                                    <h4 class="profile-card-subtitle"><strong>Branch Name:</strong>{{$vendor->vendor->branch_name}}</h4>
                                    <h4 class="profile-card-subtitle"><strong>Account Number:</strong> {{$vendor->vendor->account_number}}</h4>
                                    <h4 class="profile-card-subtitle"><strong>Account Holder's Name:</strong> {{$vendor->vendor->name_on_bank_acc}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div id="wrapper" class="mt-2">
                                <div id="image-holder">
                                    @if($vendor->vendor->bank_info_image)
                                    <img src="{{asset('images/listing/'.$vendor->vendor->bank_info_image)}}" alt="No Image" class="rounded">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane fade" id="component-1-5" role="tabpanel" aria-labelledby="component-1-5">
                <div class="ibox-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 form-group">
                                {!! $vendor->vendor->shipping_info !!}
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
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
    <div class="ibox">
        <div class="ibox-body">
            <form action="{{ route('vendor.updateCommisson') }}" method="POST">
                @csrf
                <div class="row">
                    <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                    <div class="col-md-4 form-group">
                        <label><strong>Commission Rate(In %)</strong></label>
                        <input class="form-control" type="text" name="commission_rate" value="{{@$vendor->vendor->commission_rate}}" placeholder="Enter Commisson rate here">
                    </div>
                    <div class="col-md-4 form-group">
                        <label><strong>Vendor status</strong></label>
                        <select name="vendor_type" id="vendor_status" class="form-control custom-select">
                            <option value="new" @if ($vendor->vendor_type=="new"){{"selected"}} @endif>New</option>
                            <option value="approved" @if ($vendor->vendor_type=="approved"){{"selected"}} @endif>Approved</option>
                            <option value="suspended" @if ($vendor->vendor_type=="suspended"){{"selected"}} @endif>Suspended</option>
                        </select>
                    </div>
                    @if(@$vendor->vendor->note)
                    <div class="col-md-8 md-form mb-4" id="note">
                        <label><strong style="color: red;">Note :</strong> </label>
                        <textarea name="note" class="md-textarea form-control" placeholder="Enter your reason here" rows="3">{!! @$vendor->vendor->note !!}
                    </textarea>
                    </div><br>
                    @endif
                    <div class="col-md-8 md-form mb-4 hidden" id="note">
                        <label><strong style="color: red;">Note :</strong> </label>
                        <textarea name="note" class="md-textarea form-control" placeholder="Enter your reason here" rows="8"></textarea>
                    </div><br>
                    <div class="col-md-12 form-group d-flex align-items-end">
                        <button type="submit" class="btn btn-success btn-lg"><i class="fa-solid fa-paper-plane"></i> Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-user fa-4x icon-warning"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a href="{{route('vendor.getVendorProfile',$vendor->username)}}" target="_blank">
                                Edit Profile
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="{{route('vendor.getVendorProfile',$vendor->username)}}" target="_blank">
                        <i class="fa fa-refresh"></i>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa-brands fa-product-hunt fa-4x"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a href="{{ route('vendor.getVendorProducts',$vendor->username) }}" target="_blank">
                                Products: {{ count($vendor->products) }}
                            </a>
                            <!-- <div class="card-category-count">
                                {{ count($vendor->products) }}
                            </div> -->
                        </p>

                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="{{route('vendor.getVendorProducts',$vendor->username)}}" target="_blank">
                        <i class="fa fa-refresh"></i>
                        View Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa fa-bar-chart fa-4x icon-success"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a href="/transactions/{{ $vendor->id }}">Transactions</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a href="/transactions/{{ $vendor->id }}" target=" _blank">
                        <i class="fa fa-refresh"></i>
                        View Transactions
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stats-card fade-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon">
                            <i class="fa-solid fa-money-bill fa-4x"></i>
                            <!-- <i class="fa fa-camera-retro fa-5x"></i> -->
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <p class="card-category">
                            <a target="_blank">
                                Due Amount: {{ formatted_price($due) }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0">
                <hr>
                <div class="stats">
                    <a style="color: grey;">
                        <i class="fa fa-refresh"></i>
                        Updated
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>
<script type="text/javascript">
    $(function() {
        $("#vendor_status").change(function() {
            if ($(this).val() == "suspended") {
                $("#note").show();
            } else {
                $("#note").hide();
            }
        });
    });
</script>
<script>
    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message + '</p>';
        });
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            html: html_error,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }

    function DataSuccessInDatabase(message) {
        Swal.fire({
            // position: 'top-end',
            type: 'success',
            title: 'Done',
            html: message,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }
</script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.message').fadeOut(3000);
        $('.delete').submit(function(e) {
            e.preventDefault();
            var message = confirm('Are you sure to delete');
            if (message) {
                this.submit();
            }
            return;
        });
        $('#submitVendorStatus').on('click', function() {
            var status = $('#vendor_status').val();
            var vendor_id = <?php echo $vendor->id ?>;
            $.ajax({
                url: '/api/changeVendorStatus',
                method: "POST",
                data: {
                    vendor_id: vendor_id,
                    vendor_type: status,
                    _token: "{{csrf_token()}}"
                },
                success: function(response) {
                    if (response.status == false) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == true) {
                        DataSuccessInDatabase(response.message);
                        location.reload();
                    }
                }
            })
        })
    });
</script>
@endsection