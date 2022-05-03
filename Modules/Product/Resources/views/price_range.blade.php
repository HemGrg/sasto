@extends('layouts.admin')
@section('page_title') Product @endsection

@push('push_scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush

@section('content')
<div class="page-content fade-in-up">
    <div class="page-heading d-flex mb-3">
        <h2 class="h2-responsive">{{ $updateMode ? 'Edit' : 'Add' }} Product</h2>
        <div class="ml-auto">
            <a class="btn btn-info btn-md" href="{{route('product.index')}}">All Products</a>
        </div>
    </div>
    @include('admin.section.notifications')
    <div class="ibox-body" id="validation-errors">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    </div>

    @include('product::__partials.product-form-tabs')

    <div id="app">
        <price-range :product="{{ $product }}"/>
    </div>
</div>
@endsection
