@extends('layouts.admin')
@section('page_title') Product @endsection

@section('styles')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
@endsection
@section('content')

@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title"> Product</div>
            <div>
                <a class="btn btn-info btn-md" href="/product/all">All Products</a>
            </div>
        </div>
    </div>

    <div class="ibox-body" id="validation-errors">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    </div>
    <!-- Image loader -->
    <div id='loader' style='display: none;'>
        <img src="{{ asset('/images/reload.gif') }}" width='32px' height='32px'>
    </div>
    <!-- Image loader -->
    <form id="product-create-form">

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Product Information</div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Product Title</strong></label>
                                        <input class="form-control" type="text" name="title" placeholder="Product Title Here" value="{{ old('title') }}">
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Category</strong></label>
                                        <div class="input-group">
                                            <select name="category_id" id="category_id" class="form-control custom-select">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group d-none" id="sub_cat_div">
                                        <label><strong>Sub Category</strong></label>
                                        <select class="form-control custom-select " id="subcategory_id" name="subcategory_id">
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-sm-12 form-group d-none" id="product_cat_div">
                                        <label><strong>Product Category</strong></label>
                                        <select class="form-control custom-select" id="product_category_id" name="product_category_id">
                                        </select>
                                    </div>

                                    {{-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Discount</strong></label>
                                            <input class="form-control" type="text" id="discount_bx" name="discount"
                                                placeholder="discount">


                                        </div> --}}
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Shipping Charge</strong></label>
                                        <input class="form-control" type="number" id="shipping_charge" name="shipping_charge" value="" placeholder="shipping Charge">
                                    </div>

                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label for="browser"><strong>Product Unit :</strong></label>
                                        <input list="units" class="form-control" name="unit" id="unit">
                                        <datalist id="units">
                                            <option value="pcs">
                                            <option value="kg">
                                            <option value="m">
                                        </datalist>
                                    </div>

                                    <!-- <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong> Video Link</strong></label>
                                        <input class="form-control" type="text" name="video_link" placeholder="video_link">
                                    </div> -->
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong> Video Link(Optional)</strong></label>
                                        <textarea class="form-control" name="video_link" placeholder="Youtube video link"></textarea>
                                    </div>
                                    <!-- <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Stock Quantity</strong></label>
                                            <input class="form-control" type="text" name="quantity" placeholder="stock">


                                        </div> -->
                                </div>
                                <!-- <div class="row">
                                        <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> MOQ</strong></label>
                                            <input class="form-control" type="text" id="moq" name="moq" value=""
                                                 placeholder="Minimum Order Quantity">
                                        </div>
                                        <div class="col-lg-4 col-sm-12 form-group">
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
                                        </div>

                                        <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Delivery Charge</strong></label>
                                            <input class="form-control" type="text" id="delivery_charge" name="delivery _charge" value=""
                                                 placeholder="Delivery Charge">
                                        </div>

                                        <div class="col-lg-4 col-sm-12 form-group">
                                            <label><strong> Shipping Charge</strong></label>
                                            <input class="form-control" type="text" id="shipping_charge" name="shipping _charge" value=""
                                                 placeholder="shipping Charge">
                                        </div>

                                    </div> -->

                                <div class="col-md-12 mb-3 ">
                                    <label for="">
                                        <h6><strong>Product Ranges</strong></h6>
                                    </label>
                                    <div class="field_wrapper">
                                        <div>
                                            <div class="row" style="margin-top:10px">
                                                <div class="col-md-4">
                                                    <label for="">
                                                        <strong> Range From</strong>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">
                                                        <strong> Range To</strong>
                                                    </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">
                                                        <strong> Price</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" name="from[]" value="" placeholder="Range From" class="form-control" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="to[]" value="" placeholder="Range To" class="form-control" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="prices[]" value="" placeholder="Price" class="form-control" required>
                                                </div>
                                                <a href="javascript:void(0);" class="add_button" title="Add field"><img src="{{ asset('/images/add-icon.png') }}" /></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row standard">
                                </div>
                                <div class="table-responsive-sm table-hover" id="variant_table">
                                </div>
                                <div class="mb-3 bg-white rounded p-3 ">
                                    <div id="addvariantsection" class="row  ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox">
                            <div class="ibox-body">
                                <h5 style="text-align: center;">Descriptions</h5> <br>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Payment Mode</strong></label>
                                        <input class="form-control" type="text" id="payment_mode" name="payment_mode" value="" placeholder="Payment Mode">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Country Of Origin</strong></label>
                                        <input class="form-control" type="text" id="country_of_origin" name="country_of_origin" value="" placeholder="Country Of Origin">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Brand</strong></label>
                                        <input class="form-control" type="text" id="brand" name="brand" value="" placeholder="Brand">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Available Colors</strong></label>
                                        <input class="form-control" type="text" id="colors" name="colors" value="" placeholder="Colors">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Size</strong></label>
                                        <input class="form-control" type="text" id="size" name="size" value="" placeholder="Size">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong>Brand</strong></label>
                                        <input class="form-control" type="text" name="brand" value="{{ $product->getOverviewData('brand') }}" placeholder="Brand">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Warranty</strong></label>
                                        <input class="form-control" type="text" id="warranty" name="warranty" value="" placeholder="Warranty">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Feature</strong></label>
                                        <input class="form-control" type="text" id="feature" name="feature" value="" placeholder="Feature">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Use</strong></label>
                                        <input class="form-control" type="text" id="use" name="use" value="" placeholder="Use">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Gender</strong></label>
                                        <input class="form-control" type="text" id="gender" name="gender" value="" placeholder="Gender">
                                    </div>
                                    <div class="col-lg-6 col-sm-12 form-group">
                                        <label><strong> Age Group</strong></label>
                                        <input class="form-control" type="text" id="age_group" name="age_group" value="" placeholder="Age Group">
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Product Highlights</strong></label>
                                        <textarea name="highlight" id="highlight" rows="5" placeholder="Product Highlights Here" class="form-control"></textarea>
                                    </div>
                                    {{-- <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Description</strong></label>
                                        <textarea name="description" id="description" rows="5" placeholder="description Here" class="form-control" style="resize: none;"></textarea>
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
                                            <textarea name="meta_title" id="meta_title" rows="3" class="form-control" placeholder="Meta Title" style="resize:none;"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Meta Description</strong></label>
                                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Meta Description here" style="resize:none;"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Keyword</strong></label>
                                            <textarea name="meta_keyword" id="keyword" rows="3" class="form-control" placeholder="Meta Keyword here" style="resize:none;"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><strong>Meta Keyphrase</strong></label>
                                            <textarea name="meta_keyphrase" id="meta_keyphrase" rows="3" class="form-control" placeholder="Meta Keyphrase here" style="resize:none;"></textarea>
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

                                    <input class="form-control" name="image" type="file" id="fileUpload" accept="image/*">
                                    <div id="wrapper" class="mt-2">
                                        <div id="image-holder">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="video_link"><strong>YouTube Video Link </strong></label>
                                    <input class="form-control" name="video_link" placeholder="video link">
                                </div>

                                <div class="form-group">
                                    <label class="ui-checkbox ui-checkbox-primary">
                                        <input type="checkbox" id="is_new_arrival" name="is_new_arrival" value="1">
                                        <span class="input-span"></span><strong>New Arrival</strong>
                                    </label>
                                </div>

                                @if(auth()->user()->hasAnyRole('super_admin|admin'))
                                <div class="form-group">
                                    <label class="ui-checkbox ui-checkbox-primary">
                                        <input type="checkbox" id="is_top" name="is_top" value="1">
                                        <span class="input-span"></span><strong>Top Product</strong>
                                    </label>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label for="status">Status: </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button onclick="submitProductNow(event);" type="button" id="product_submit" class="btn btn-success btn-lg btn-block">Save</button>
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
<script src="{{ asset('/assets/admin/js/sweetalert.js') }}" type="text/javascript"></script>
@include('dashboard::admin.layouts._partials.imagepreview')

@foreach ($name as $data)
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach

@endpush

@section('scripts')

<script>
    function showThumbnail(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        }
        reader.onload = function(e) {
            $('#thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }

    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message +
                '</p>';
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


<script>
    $(document).ready(function(e) {
        function brands() {
            $.ajax({
                type: 'GET',
                url: '/api/allbrands',
                success: function(response) {
                    if (response.data) {
                        var html_options = "<option value=''>select any one</option>";
                        $.each(response.data, function(index, cat_data) {
                            html_options += "<option value='" + cat_data.id + "'>" +
                                cat_data.title + "</option>";
                        });
                        $('#brand_id').html(html_options);
                    }
                },
                error: function(error) {
                    $('#notification-bar').text('An error occurred');
                }
            });
        }
        // Get the brands
        brands();
    });
</script>

<script>
    $(document).ready(function(e) {
        function offers() {
            $.ajax({
                type: 'GET',
                url: '/api/getoffers',

                success: function(response) {
                    if (response.data) {
                        var html_options = "<option value=''>select any one</option>";
                        $.each(response.data, function(index, offer_data) {
                            html_options += "<option value='" + offer_data.id + "'>" +
                                offer_data.title + "</option>";
                        });
                        $('#offer_id').html(html_options);
                    }
                },
                error: function(error) {
                    $('#notification-bar').text('An error occurred');
                }
            });
        }
        // Get the offers
        offers()
    });
</script>

<script>
    $(document).ready(function(e) {

        function categories() {
            $.ajax({
                type: 'GET',
                url: '/api/getcategories',

                success: function(response) {
                    if (response.data) {
                        var html_options = "<option value=''>select any one</option>";
                        $.each(response.data, function(index, cat_data) {
                            html_options += "<option value='" + cat_data.id + "'>" +
                                cat_data.name + "</option>";
                        });
                        $('#category_id').html(html_options);
                    }
                },
                error: function(error) {
                    $('#notification-bar').text('An error occurred');
                }
            });
        }
        // Get the categories
        categories()
    });
</script>
<script>
    function plus() {
        $(document).keypress(function(e) {
            e.which == 13;
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 20; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = `<div class="field_wrapper" style="margin-top:10px">
                        <div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input  type="text"  name="from[]" value="" placeholder="Range From" class="form-control">
                                </div>
                                <div class="col-md-3">
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
    function addVariantRow() {
        let variantTable = $('#variantTbl').find("tbody");
        let firstRowVariantTable = variantTable.find('tr:first');
        let lastRowVariantTable = variantTable.find('tr:last');
        let trNew = firstRowVariantTable.clone();
        trNew.css('display', 'table-row');
        lastRowVariantTable.after(trNew);
    }
    $(document).ready(function() {

        // let lastRemoveButton =  $('#variantTbl tr:last').find('.remove-variant');
        // lastRemoveButton.css("display","none");
        $('#category_id').on('change', function() {
            $('.product-value').prop('checked', false);
            $('#variant_table ').html("");
        });


        $('#subcategory_id').on('change', function() {
            $('.product-value').prop('checked', false);
            $('#variant_table ').html("");
        });

        $('.product-value').click(function(e) {
            let cat_id = $('#category_id').val();
            let sub_cat_id = $('#subcategory_id').val();

            if (cat_id == null || cat_id == undefined || cat_id == "") {

                alert("Select a category");
                $(this).prop('checked', !$(this).prop('checked'));
                return;
            }
            var productValue = $("input[name='product_type']:checked").val()
            if (productValue === 'variant_product') {
                $.ajax({
                    type: 'GET',
                    url: '/api/getproductattributes',
                    data: {
                        sub_cat_id: sub_cat_id,
                        cat_id: cat_id,
                    },
                    success: function(response) {
                        if (response.data) {
                            if (response.data.length > 0) {
                                $('#variant_table ').html(response.html);
                            } else {
                                $('#variant_table ').html("");
                            }
                        }
                    },
                    error: function(error) {
                        $('#variant_table ').html("");
                        $('#notification-bar').text('An error occurred');
                    }
                });
            } else {
                $("#variant_table").html("");
            }

        });
    });
</script>
<script>
    function addproductvariant() {
        $('#attributeModal').modal('show');
        $('#submitProductAttribute').on('click', function() {
            var title = $('#product_attribute_title').val();
            $.ajax({
                url: "/api/createproductattribute",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    title: title,
                },
                success: function(response) {
                    if (response.status == 'successful') {
                        $('#attributeModal').modal('hide');
                        var modal_title = "Success";
                        modal_title = modal_title.fontcolor('green');
                        $('#popup-modal-body').append(response.message);
                        $('#popup-modal-title').append(modal_title);
                        $('#popup-modal-btn').addClass('btn-success');
                        $("#popupModal").modal('show');
                    }
                }
            });

        });

    }
</script> -->


<script>
    $(document).ready(function() {
        $('#category_id').change(function(e) {
            e.preventDefault();
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "/api/getsubcategory",
                    type: "POST",
                    data: {
                        category_id: category_id
                    },

                    success: function(response) {
                        if (response.data) {
                            $('#sub_cat_div').removeClass('d-none');

                            var html_options = "<option value=''>select any one</option>";
                            $.each(response.data, function(index, subcat_data) {
                                html_options += "<option value='" + subcat_data.id +
                                    "'>" + subcat_data.name + "</option>";
                            });
                            $('#subcategory_id').html(html_options);

                        } else {
                            $("#subcategory_id").empty();
                        }
                        if (response.category) {
                            $('#sub_cat_div').addClass('d-none');
                        }
                    }
                });
            } else {
                $("#subcategory_id").empty();
            }
        });

        $('#subcategory_id').change(function(e) {
            e.preventDefault();
            var subcategory_id = $(this).val();
            if (subcategory_id) {
                $.ajax({
                    url: "/api/get-product-category",
                    type: "POST",
                    data: {
                        subcategory_id: subcategory_id
                    },

                    success: function(response) {
                        if (response.data) {
                            $('#product_cat_div').removeClass('d-none');

                            var html_options = "<option value=''>select any one</option>";
                            $.each(response.data, function(index, productCategory) {
                                html_options += "<option value='" + productCategory.id +
                                    "'>" + productCategory.name + "</option>";
                            });
                            $('#product_category_id').html(html_options);

                        } else {
                            $("#product_category_id").empty();
                        }
                        if (response.category) {
                            $('#product_cat_div').addClass('d-none');
                        }
                    }
                });
            } else {
                $("#product_cat_div").empty();
            }
        });
    });
</script>

<script>
    function submitProductNow(event) {
        event.preventDefault();
        $('#product_submit').html('Submitting...');

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        var productCreateForm = document.getElementById("product-create-form");
        var formData = new FormData(productCreateForm);

        $.ajax({
            type: 'POST',
            url: "/api/createproduct",
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 'successful') {
                    var validation_errors = JSON.stringify(response.message);
                    DataSuccessInDatabase(validation_errors);
                    window.location.href = "/product/all";
                } else if (response.status == 'unsuccessful') {
                    $('#product_submit').html('Save');
                    var validation_errors = JSON.stringify(response.data);
                    var response = JSON.parse(validation_errors);
                    FailedResponseFromDatabase(response);
                    // $('#validation-errors').html(''); 
                    // $.each( response, function( key, value) {
                    //     $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
                    //     }); 
                }
            },
        });
    }
</script>

@endsection