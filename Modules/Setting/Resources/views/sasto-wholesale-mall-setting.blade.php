@extends('layouts.admin')

@section('content')
<div class="container py-2">
    <h4 class="h4-responsive py-4">{{ $title }}</h4>
    <form action="{{ route('settings.sastowholesale-mall.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-0 shadow-sm">
            <div class="card-body">
                <div class="form-group">
                    <label>Sasto Wholesale Shop Name</label>
                    <select class="js-example-basic-single form-control @error('sasto_wholesale_mall_vendor_id') is-invalid @enderror" name="sasto_wholesale_mall_vendor_id">
                        <option value="">Select Vendor...</option>
                        @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ old('sasto_wholesale_mall_vendor_id', settings('sasto_wholesale_mall_vendor_id')) == $vendor->id ? 'selected' : '' }}>{{ $vendor->shop_name }}</option>
                        @endforeach
                    </select>
                    <x-invalid-feedback field="sasto_wholesale_mall_vendor_id"></x-invalid-feedback>
                </div>

                <div class="form-group">
                    <label for="">Number of products to show in homepage Sasto Wholesale Mall section</label>
                    <input type="text" name="sasto_wholesale_mall_home_products_count" class="form-control @error('sasto_wholesale_mall_home_products_count') is-invalid @enderror" value="{{ old('sasto_wholesale_mall_home_products_count', settings('sasto_wholesale_mall_home_products_count')) }}">
                    <x-invalid-feedback field="sasto_wholesale_mall_home_products_count"></x-invalid-feedback>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary px-4">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('push_scripts')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            theme: 'bootstrap4'
        });
    });

</script>
@endpush
