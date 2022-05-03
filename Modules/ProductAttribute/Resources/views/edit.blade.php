<?php
    $user = Auth::user();
    $api_token = $user->api_token;
?>

@extends('layouts.admin')
@section('page_title', 'Add Product Attribute')

@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Create Product Attribute</div>

                    <div class="ibox-tools">

                    </div>
                </div>

                <div class="ibox-body" id="validation-errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>

                <div class="ibox-body" style="">
                    <form>
                        <div class="col-lg-12 col-sm-12 form-group">
                            <label><strong>Category</strong></label>

                            <select name="category_id[]" id="category_id" class="form-control" multiple required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if((in_array($category->id, array_column($cat->toArray(), 'category_id')))) {{"selected"}} @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12 col-sm-12 form-group" id="sub_cat_div">
                            <label><strong>Sub Category</strong></label>
                            <select class="form-control " id="subcategory_id" name="subcategory_id[]" multiple required>
                            @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" @if((in_array($subcategory->id, array_column($subcat->toArray(), 'subcategory_id')))) {{"selected"}} @endif>{{ $subcategory->name }}</option>
                                @endforeach
                                
                            </select>
                        </div>


                        <div class="col-lg-12 col-sm-12 form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{$productAttribute->title}}"
                                placeholder="Enter title">
                        </div>
                        <div class="table-hover" id="variant_table">

                            <button type="button" class="btn btn-primary pull-right"
                                onclick="addVariantRow()">Add</button>
                            <table class="table" id="optionTbl">
                                <thead>
                                    <tr>
                                        <th>Value</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php 
                                     $value = unserialize($productAttribute->options);
                                    @endphp
                                    <tr style="display:none">
                                        <td><input class="form-control" name="options[]"  />
                                        </td>
                                        <td><button type="button" class="btn btn-danger remove-variant"
                                        onclick="if(confirm('Are you want to remove this row')){$(this).closest('tr').remove()}">Remove</button>
                                        </td>
                                    </tr>
                                    @if(count($value)>0) 
                                        @foreach($value as $val)
                                            <tr>
                                                <td><input class="form-control" name="options[]" value="{{$val}}"  />
                                                </td>
                                                <td><button type="button" class="btn btn-danger remove-variant"
                                                onclick="if(confirm('Are you want to remove this row')){$(this).closest('tr').remove()}">Remove</button>
                                                </td> 
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="check-list">
                            <label class="ui-checkbox ui-checkbox-primary">
                                <input name="publish" id="publish" type="checkbox" {{$productAttribute->publish ==1 ? 'checked' : ''}}  >
                                <span class="input-span"></span>Publish</label>
                        </div>

                        <br>

                        <div class="form-group">
                            <button type="button" id="submitattribute" name="submit"
                                class="btn btn-success ">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>



</div>

@endsection

@push('push_scripts')

<style>
    li.badge {
        color: black;
    }
</style>
<script>
    function addVariantRow(){
        let variantTable = $('#optionTbl').find("tbody");
        let firstRowVariantTable = variantTable.find('tr:first');
        let lastRowVariantTable = variantTable.find('tr:last');
        let trNew = firstRowVariantTable.clone();
        trNew.css('display','table-row');
        lastRowVariantTable.after(trNew);
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#category_id").bsMultiSelect();
    $("#sub_cat_div").bsMultiSelect();

	$('#submitattribute').on('click', function(){
    var api_token = '<?php echo $api_token; ?>';
    var id = '<?php echo $productAttribute->id; ?>';
    var title = $('#title').val();
    var category_id = $('#category_id').val();
    var subcategory_id = $('#subcategory_id').val();
    var options = $("input[name='options[]']")
    .map(function(){return $(this).val();}).get();
    options.shift();
    var publish = $('#publish').val();
     $.ajax({
          url: "/api/updateproductattribute",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            id:id,
            title:title,
            category_id:category_id,
            subcategory_id:subcategory_id,
            publish:publish,
            options:options
          },
          headers: {
            Authorization: "Bearer " + api_token
        },
          success:function(response){
            console.log(response.data);
            if(response.status == 'successful'){
                window.location.href = "/admin/productattribute";
                var validation_errors = JSON.stringify(response.message);
                $('#validation-errors').html('');
                $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
            } else if(response.status == 'unsuccessful') {
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
</script>
@endpush
