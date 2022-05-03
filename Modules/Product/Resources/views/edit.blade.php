@extends('layouts.admin')
@section('page_title') Product @endsection

@section('styles')
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" /> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css" rel="stylesheet" /> -->
<!-- <link href="{{ asset('/assets/admin/tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" /> -->

@endsection


@section('content')

<div class="page-heading">
    <h1 class="page-title"> Product</h1>
</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Edit Product</div>
            <div>
                <a class="btn btn-info btn-md" href="/product/all">All Products</a>
            </div>
        </div>
    </div>

    <div class="ibox-body" id="validation-errors">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    </div>
    <form id="product-update-form">

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Product Information</div>
                            </div>
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Product Title</strong></label>
                                        <input class="form-control" type="text" id="title" name="title" value="{{ $product->title }}" placeholder="Product Title Here">
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Category</strong></label>
                                        <div class="input-group">
                                            <select name="category_id" id="category_id" class="form-control custom-select">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @if($categoryId==$category->id) selected @endif>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group" id="sub_cat_div">
                                        <label><strong>Sub Category</strong></label>
                                        <select class="form-control custom-select " id="subcategory_id" name="subcategory_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            @foreach ($category->subcategory as $subcat)
                                            <option value="{{ $subcat->id }}" data-category-id="{{ $category->id }}" @if($subcategoryId==$subcat->id) selected @endif>{{ $subcat->name }}</option>
                                            @endforeach
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group" id="product_cat_div">
                                        <label><strong>Product Category</strong></label>
                                        <select class="form-control custom-select" id="product_category_id" name="product_category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            @foreach ($category->subcategory as $subcat)
                                            @foreach ($subcat->productCategory as $productCat)
                                            <option value="{{ $productCat->id }}" data-subcategory-id="{{ $subcat->id }}" @if($product->product_category_id == $productCat->id) selected @endif> {{ $productCat->name }}</option>
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="col-lg-4 col-sm-12 form-group">
                                        <label><strong> Discount</strong></label>
                                        <input class="form-control" type="text" id="discount" name="discount" placeholder="discount">
                                    </div> --}}
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Shipping Charge</strong></label>
                                        <input class="form-control" type="number" id="shipping_charge" name="shipping_charge" value="{{ $product->shipping_charge }}" placeholder="shipping Charge">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="browser"><strong>Product Unit</strong></label>
                                        <input list="units" class="form-control" name="unit" id="unit" value="{{ $product->unit }}">
                                        <datalist id="units">
                                            <option value="pcs">
                                            <option value="kg">
                                            <option value="m">
                                        </datalist>
                                    </div>

                                    <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Stock Quantity</strong></label>
                                            <input class="form-control" type="text" id="quantity" name="quantity" placeholder="stock">
                                        </div> -->
                                    <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> MOQ</strong></label>
                                            <input class="form-control" type="text" id="moq" name="moq" value="" name="price" placeholder="Minimum Order Quantity">
                                        </div> -->

                                    <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label class="ui-checkbox ui-checkbox-primary" style="margin-top: 35px;">
                                                <input type="checkbox" id="essential" name="essential" value="1">
                                                <span class="input-span"></span><strong>Essential</strong>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 form-group">
                                            <label class="ui-checkbox ui-checkbox-primary" style="margin-top: 35px;">
                                                <input type="checkbox" id="best_seller" name="best_seller" value="1">
                                                <span class="input-span"></span><strong>Best Seller</strong>
                                            </label>
                                        </div> -->
                                </div>
                            </div>
                        </div>

                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label for="">
                                            <h5>Price Ranges</h5>
                                        </label>
                                        <a href="javascript:void(0);" class="add_button pull-right" title="add field"><img src="{{ asset('/images/add-icon.png') }}" /></a>
                                        <div class="field_wrapper">
                                            <div class="mt-2">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="">
                                                            <strong>From Quantity</strong>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">
                                                            <strong>To Quantity</strong>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">
                                                            <strong> Price</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                                @foreach ($product->ranges as $range)
                                                <div class="row mt-2">
                                                    <div class="col-md-4">
                                                        <input type="text" name="from[]" value="{{ $range->from }}" placeholder="Range From" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="to[]" value="{{ $range->to }}" placeholder="Range To" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="prices[]" value="{{ $range->price }}" placeholder="Price" class="form-control" required>
                                                    </div>
                                                    <a href="javascript:void(0);" class="remove_button" title="remove field"><img src="{{ asset('/images/remove-icon.png') }}" /></a>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ibox">
                            <div class="ibox-body">
                                <h5>Quick Details</h5>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Payment Mode</strong></label>
                                        <input class="form-control" type="text" id="payment_mode" name="payment_mode" value="{{ $product->getOverviewData('payment_mode') }}" placeholder="Payment Mode">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Country Of Origin</strong></label>
                                        <input class="form-control" type="text" id="country_of_origin" name="country_of_origin" value="{{ $product->getOverviewData('country_of_origin') }}" placeholder="Country Of Origin">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Brand</strong></label>
                                        <input class="form-control" type="text" id="brand" name="brand" value="{{@$product->overview->brand}}" placeholder="Brand">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Available Colors</strong></label>
                                        <input class="form-control" type="text" id="colors" name="colors" value="{{ $product->getOverviewData('colors') }}" placeholder="Colors">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Size</strong></label>
                                        <input class="form-control" type="text" id="size" name="size" value="{{ $product->getOverviewData('size') }}" placeholder="Size">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Brand</strong></label>
                                        <input class="form-control" type="text" name="brand" value="{{ $product->getOverviewData('brand') }}" placeholder="Brand">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Warranty</strong></label>
                                        <input class="form-control" type="text" id="warranty" name="warranty" value="{{ $product->getOverviewData('warranty') }}" placeholder="Warranty">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Feature</strong></label>
                                        <input class="form-control" type="text" id="feature" name="feature" value="{{ $product->getOverviewData('feature') }}" placeholder="Feature">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Use</strong></label>
                                        <input class="form-control" type="text" id="use" name="use" value="{{ $product->getOverviewData('use') }}" placeholder="Use">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Gender</strong></label>
                                        <input class="form-control" type="text" id="gender" name="gender" value="{{ $product->getOverviewData('gender') }}" placeholder="Gender">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Age Group</strong></label>
                                        <input class="form-control" type="text" id="age_group" name="age_group" value="{{ $product->getOverviewData('age_group') }}" placeholder="Age Group">
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Product Highlights</strong></label>
                                        <textarea name="highlight" id="highlight" rows="5" placeholder="Product Highlights Here" class="form-control" style="resize: none;"></textarea>
                                    </div>
                                    {{-- <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Description</strong></label>
                                        <textarea name="description" id="description" rows="5" placeholder="description Here" class="form-control" style="resize: none;">{{ $product->description }}</textarea>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="ibox">
                            <div class="ibox-body">
                                <h5>SEO Tools</h5>
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for=""><strong>Meta Title</strong></label>
                                            <input type="text" name="meta_title" class="form-control" value="{{ $product->meta_title }}" placeholder="Meta Title">
                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Meta Description</strong></label>
                                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Meta Description here" style="resize:none;">{{ $product->meta_description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Keyword</strong></label>
                                            <textarea name="meta_keyword" id="keyword" rows="3" class="form-control" placeholder="Meta Keyword here" style="resize:none;">{{ $product->meta_keyword }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Meta Keyphrase</strong></label>
                                            <textarea name="meta_keyphrase" id="meta_keyphrase" rows="3" class="form-control" placeholder="Meta Keyphrase here" style="resize:none;">{{ $product->meta_keyphrase }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="form-group">
                                    <label> Upload Main Banner [image size: width: 800px, height: 800px] [image type: jpg, jpeg, png] </label>
                                        <div id="wrapper" class="mb-2">
                                            <div id="image-holder">
                                                <img class="rounded" src="{{ $product->image ? $product->imageUrl() : 'https://dummyimage.com/800x800/e8e8e8/0011ff' }}" width="150" height="150">
                                            </div>
                                        </div>
                                        <input class="" name="image" type="file" id="fileUpload" accept="image/*">
                                </div>

                                <div class="form-group">
                                    <label for="video_link"><strong>YouTube Video Link </strong></label>
                                    <input class="form-control" name="video_link" placeholder="video link" value="{{ $product->video_link }}">
                                </div>

                                <div class="form-group">
                                    <label class="ui-checkbox ui-checkbox-primary">
                                        <input type="checkbox" id="is_new_arrival" name="is_new_arrival" value="1" @if($product->is_new_arrival) checked @endif>
                                        <span class="input-span"></span><strong>New Arrival</strong>
                                    </label>
                                </div>

                                @if(auth()->user()->hasAnyRole('super_admin|admin'))
                                <div class="form-group">
                                    <label class="ui-checkbox ui-checkbox-primary">
                                        <input type="checkbox" id="is_top" name="is_top" value="1" @if($product->is_top) checked @endif>
                                        <span class="input-span"></span><strong>Top Product</strong>
                                    </label>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label for="status"><strong>Status</strong></label>
                                    <select name="status" id="status" class="form-control custom-select">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                
                                <div class="form-group">
                                    <button onclick="submitProductNow();" type="button" id="product_submit" class="btn btn-success btn-lg btn-block">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>


<!-- Modal -->
@include('dashboard::admin.modals.attributemodal')
@include('dashboard::admin.modals.categorymodal')

<div class="modal" id="popupModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="popup-modal-title" class="modal-title">
                    </h5>
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
<?php
$name = ['highlight'];
?>
@push('push_scripts')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('/assets/admin/js/sweetalert.js') }}" type="text/javascript"></script>

@include('dashboard::admin.layouts._partials.imagepreview')

@foreach ($name as $data)
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach

@endpush
@push('push_scripts')
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

<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = `<div class="field_wrapper" style="margin-top:10px">
                        <div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input  type="text"  name="from[]" value="" placeholder="Range From" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <input  type="text"  name="to[]" value="" placeholder="Range To" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input  type="text"  name="prices[]" value="" placeholder="Price" class="form-control">
                                </div>
                                <a href="javascript:void(0);" class="remove_button" title="Add field"><img src="{{ asset('/images/remove-icon.png') }}"/></a>
                            </div>
                        </div>
                    </div>`;
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>

<script>

    $(document).ready(function() {
        // Filter subcategory
        function filterSubcategory(selectedCategoryId) {
            // let selectedCategoryId = $(this).val()
            $('#subcategory_id option').each(function() {
                if ($(this).data('category-id') == selectedCategoryId || $(this).attr('value') == '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        
        // Filter product category
        function filterProductCategory(selectedSubcategoryId) {
            $('#product_category_id option').each(function() {
                if ($(this).data('subcategory-id') == selectedSubcategoryId || $(this).attr('value') == '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        // On form load
        filterSubcategory({{ $categoryId }});
        filterProductCategory({{ $subcategoryId }});

        $('#category_id').change(function() {
            filterSubcategory($(this).val());
            $('#subcategory_id').val('');
        });

        $('#subcategory_id').change(function() {
            filterProductCategory($(this).val());
            $('#product_category_id').val('');
        });

    });
</script>

<script>
    function submitProductNow() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var id = "<?php echo $product->id; ?>";
        var productCreateForm = document.getElementById("product-update-form");
        var formData = new FormData(productCreateForm);
        formData.append('id', id);
        $.ajax({
            type: 'POST',
            url: "/api/updateproduct",
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 'successful') {
                    window.location.href = "/product/all";
                    var validation_errors = JSON.stringify(response.message);
                    $('#validation-errors').html('');
                    $('#validation-errors').append('<div class="alert alert-success">' + validation_errors +
                        '</div');
                } else if (response.status == 'unsuccessful') {
                    var validation_errors = JSON.stringify(response.data);
                    var response = JSON.parse(validation_errors);
                    $('#validation-errors').html('');
                    $.each(response, function(key, value) {
                        $('#validation-errors').append('<div class="alert alert-danger">' + value +
                            '</div');
                    });
                }
            }
        });
    }
</script>
@endpush