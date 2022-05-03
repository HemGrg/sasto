<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title')  Order @endsection

@section('content')

<div class="page-heading">
    <h1 class="page-title"> Order</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href=""><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> Add New  Order</li>
    </ol>

</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">

            <div class="ibox-title">Add New Order</div>

            <div>
                <a class="btn btn-info btn-md" href="">All Order List</a>
            </div>
        </div>
    </div>
    <div class="ibox-body" id="validation-errors" >
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            </div>
    <form class="form form-responsive form-horizontal" id="order-update-form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-12" id="get__print">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Order Information</div>
                                    <div class="ibox-tools">
                                        {{--
                                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                                    --}}
                                    </div>
                                </div>
                                <div class="ibox-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 form-group">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr >
                                                        <th>Product Title</th>
                                                        <th>Vendor</th>
                                                        <th>Shipping Charge</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Status</th>
                                                        <th>Total amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->order_list as $order_list)

                                                    <?php 
                                                    $role = \Modules\Order\Entities\OrderList::checkUserRole($order_list->user_id);
                                                    $vendor = \Modules\Order\Entities\OrderList::checkVendor($order_list->user_id);
                                                    ?>
                                                    
                                                    <tr>
                                                        <td id="product_title">
                                                        {{$order_list->product_info->title}}
                                                        </td>
                                                        <td >
                                                        {{$vendor}}
                                                        </td>
                                                        <td>{{$order_list->product_info->shipping_charge}}</td>
                                                        <td id="quantity">
                                                        {{$order_list->quantity}}
                                                        </td>

                                                        <td id="amount">
                                                        @if($order_list->product_info->ranges->isEmpty())
                                                        {{$order_list->product_info->price}}
                                                        @endif
                                                            @foreach($order_list->product_info->ranges as $range)
                                                                @if($range->from <= $order_list->quantity && $range->to >= $order_list->quantity)
                                                                {{$range->price}}
                                                                
                                                                @endif
                                                            @endforeach
                                                                
                                                        </td>
                                                        @if(Auth::user()->id == $order_list->product_info->user_id)
                                                        <td><span class="btn btn-rounded btn-sm {{orderProccess($order_list->order_status) }} changeStatus"
                                                        data-status="{{$order_list->order_status}}" data-order_id="{{$order_list->id}}"
                                                        style="cursor: pointer;">{{$order_list->order_status}}</span></td>
                                                        @else 
                                                        <td>{{$order_list->order_status}}</td>
                                                        @endif
                                                        <td id="total_amount">
                                                        {{$order_list->amount}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="6">
                                                            <b>Grand Total=</b>
                                                        </td>
                                                        <td><b>{{
                                                        array_reduce($order->order_list->toArray(),function($total,$item){
                                                            $total+=  $item['amount'];
                                                            return $total; 
                                                        },0)    
                                                        }}</b>
                                                        </td>
                                                    </tr>
                                                </tbody>

                                                </tbody>
                                                <tfoot></tfoot>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4><strong>Shipping Detail</strong></h4>
                                        </div>
                                        {{--
                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label>Product Title</label>
                                    <input class="form-control" type="text" id="" value="{{(@$order_info->product_info->title) ? @$order_info->product_info->title : old('title')}}"
                                        name="title" placeholder="Product Title Here" disabled>
                                        @if($errors->has('title'))
                                        <span class=" alert-danger">{{$errors->first('title')}}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Quantity</label>
                                        <input class="form-control" type="text"
                                            value="{{(@$order_info->quantity) ? @$order_info->quantity : old('quantity')}}"
                                            name="quantity" placeholder="Product quantity Here" >
                                        @if($errors->has('title'))
                                        <span class=" alert-danger">{{$errors->first('title')}}</span>
                                        @endif
                                    </div>
                                    --}}
                                   
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Name</label>
                                        <input class="form-control" id="name" type="text"
                                            value="{{$order->user->name}}" name="name" placeholder="Name" disabled
                                            >
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="text" id="email"
                                            value="{{$order->user->email}}" name="name" placeholder="Email" disabled
                                            >

                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Phone No</label>
                                        <input class="form-control" type="text" id="phone_num"
                                            value="{{$order->phone}}"
                                            name="phone" placeholder="Product phone Here"  disabled> 
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Track No</label>
                                        <input class="form-control" type="text" value="{{$order->track_no}}" id="track_no"
                                            name="order_id" placeholder="Product order_id Here" disabled>
                                       
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>City</label>
                                        <input class="form-control" type="text" id="city"
                                            value="{{$order->city}}"
                                            name="city" placeholder="Product city Here" disabled >
                                        
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label>Address</label>
                                        <textarea name="address" id="address" rows="3" 
                                            class="form-control resize_no" disabled>{{$order->address}}</textarea>

                                        @if($errors->has('address'))
                                        <span class=" alert-danger">{{$errors->first('address')}}</span>
                                        @endif
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label>Order Note</label>
                                        <textarea name="order_note" id="order_note" rows="3" 
                                            class="form-control resize_no" disabled>{{$order->order_note}}</textarea>

                                        @if($errors->has('order_note'))
                                        <span class=" alert-danger">{{$errors->first('order_note')}}</span>
                                        @endif
                                    </div>

                                    
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-body">
                                        
                             @if($role == 'vendor')
                                <div class="form-group">
                                    <label>Order Status:</label>
                                    <span class="btn btn-rounded btn-sm {{orderProccess($order->status) }}"
                                    style="cursor: pointer;">{{$order->status}}</span>
                                </div>
                              @else 
                                <div class="form-group">
                                    <label>Order Status:</label>
                                    <select name="status" id="status" class="form-control ">
                                        <option value="New" >New</option>
                                        <option value="Verified" >Verified</option>
                                        <option value="Process" >Processing</option>
                                        <option value="Delivered" >Delivered</option>
                                        <option value="Cancel" >Cancel</option>
                                    </select>
                                </div>
                              @endif
                                

                                @if($errors->has('status'))
                                <span class=" alert-danger">{{$errors->first('status')}}</span>
                                @endif
                                            {{$role}}
                                @if($role == 'admin' || $role == 'super_admin')
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit"> <span class="fa fa-send"></span>
                                        Save</button>
                                    </div>           
                                @endif
                                
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
</div>
</form>
<button class="btn btn-sm print__button btn-primary">Print</button>

</div>
<!-- Modal -->
@include('dashboard::admin.modals.orderstatusmodal')
<div class="modal" id="popupModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
		<div class="modal-header">
        <h3 id="popup-modal-title" class="modal-title"></h5>
      </div>
			<div class="modal-body">
				<div style="text-align: center;" id="popup-modal-body"></div>
			</div>
			<div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')


<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript" src="{{asset('/assets/admin/js/laravel-file-manager-ck-editor.js')}}"></script>
<script src="/assets/admin/js/printThis.js"></script>

<script type="text/javascript">
    $('.print__button').click(function() {
        $("#get__print").printThis({
            header: null,
            footer: null,
        });
    });
</script>


<script>
    function showThumbnail(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        }
        reader.onload = function(e){
            $('#thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }

</script>
<script >
  	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
       $('.message').fadeOut(3000);
       $('.delete').submit(function(e){
        e.preventDefault();
        var message=confirm('Are you sure to delete');
        if(message){
          this.submit();
        }
        return;
       });

       
        $('body').on('click', '.changeStatus' ,function(e){
            var order_id = $(this).data('order_id');
            console.log(order_id)
            $('#orderStatusModal').modal('show');
            
            $('#submitOrderStatus').on('click', function(){
            var status = $('#order_status').val();

            
            $.ajax({
                url: "/api/updateorderstatus",
                type:"POST",
                data:{
                "_token": "{{ csrf_token() }}",
                order_id:order_id,
                status:status,
                },
                success:function(response){
                    if(response.status == 'successful'){
                        $('#orderStatusModal').modal('hide');
                            var modal_title = "Success";
					modal_title = modal_title.fontcolor('green');
                    $('#popup-modal-body').append(response.message);
                    $('#popup-modal-title').append(modal_title);
                    $('#popup-modal-btn').addClass('btn-success');
					$("#popupModal").modal('show');
                    location.reload();
                    }
                    // if(response.status == 'unsuccessful'){
                    //         var modal_title = "Failed";
					// modal_title = modal_title.fontcolor('red');
                    // $('#popup-modal-body').append(response.data.title);
                    // $('#popup-modal-title').append(modal_title);
					// $("#popupModal").modal('show');
                    // }
                }
            });
            
        });
            
            
        })
    
       
       
    });

    $(function () {
        $("#example1").DataTable();
    });

    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    

  </script>

<script>
	$(document).ready(function (e) {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#order-update-form').submit(function(e) {
        // var id = "<?php
            //  echo $id;
              ?>";
        // var api_token = '<?php 
        // echo $api_token;
         ?>';
        e.preventDefault();
  
  var formData = new FormData(this);
  formData.append('id', id);
  $.ajax({
        type:'POST',
        url: "/api/updateorder",
        data: formData,
        enctype: 'multipart/form-data',
        cache:false,
        contentType: false,
        processData: false,
        headers: {
            Authorization: "Bearer " + api_token
        },
        success:function(response){
            if(response.status == 'successful'){
              window.location.href = "/admin/order";
              var validation_errors = JSON.stringify(response.message);
                $('#validation-errors').html('');
                $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
                }  else if(response.status == 'unsuccessful') {
              var validation_errors = JSON.stringify(response.data);
            var response = JSON.parse(validation_errors);
            $('#validation-errors').html('');
            $.each( response, function( key, value) {
            $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
            });
                }
        }
        
       });
   });
   });

	
</script>

@endsection