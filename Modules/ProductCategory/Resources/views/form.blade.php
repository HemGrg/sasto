@extends('layouts.admin')

@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <a href="{{ route('product-category.index') }}" class="btn btn-primary ml-md-0 ml-3">Back to listing</a>
            </div>

            <x-validation-errors></x-validation-errors>

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">{{ $updateMode ? 'Update' : 'Add New' }} Product Category</div>
                    <div class="ibox-tools">
                    </div>
                </div>

                <div class="ibox-body" style="">
                    <form id="subcategory-create-form" action="{{ $updateMode ? route('product-category.update', $productCategory->id) : route('product-category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($updateMode)
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $productCategory->id }}">
                        @endif
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $productCategory->name) }}" placeholder="Enter name" required>
                            <x-invalid-feedback field="name" />
                        </div>

                        @if($updateMode)
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $productCategory->slug) }}" placeholder="Enter name" required>
                            <x-invalid-feedback field="slug" />
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="">Category</label>
                            <select class="form-control custom-select" id="js-category-id" name="category_id" required>
                                <option value="">Choose one...</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Sub Category</label>
                            <select class="form-control custom-select @error('subcategory_id') is-invalid @enderror" id="js-sub-category-id" name="subcategory_id" required>
                                <option value="">Choose one...</option>
                                @foreach ($categories as $category)
                                @foreach ($category->subcategory as $cat)
                                <option value="{{ $cat->id }}" data-category-id="{{ $category->id }}">{{ $cat->name }}</option>
                                @endforeach
                                @endforeach
                            </select>
                            <x-invalid-feedback field="subcategory_id" />
                        </div>

                        {{-- @if(auth()->user()->hasAnyRole(['super_admin', 'admin']))
                        <div class="form-group">
                            <label class="ui-checkbox ui-checkbox-warning">
                                <input type="checkbox" name="is_featured" id="is_featured">
                                <span class="input-span"></span>Shown in Hot Category section of homepage.
                            </label>
                        </div>
                        @endif --}}

                        <div class="form-group">
                            <label>Image </label>
                            <input class="form-control-file" name="image" type="file" onchange="handleUploadPreview()" data-preview-el-id="js-product-cat-img-preview" accept="image/*">
                            <div class="py-2">
                                <img id="js-product-cat-img-preview" class="rounded" src="{{ $productCategory->image ? $productCategory->imageUrl() : 'https://dummyimage.com/400x400/e8e8e8/0011ff' }}" style="max-height: 150px;">
                            </div>
                        </div>

                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <div class="form-group">
                            <div class="check-list">
                                <label class="ui-checkbox ui-checkbox-primary">
                                    <input name="publish" type="checkbox" value="1" @if($productCategory->publish) checked @endif>
                                    <span class="input-span"></span>Publish
                                </label>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <button type="submit" class="btn btn-success px-4 border-0">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('push_scripts')
@include('dashboard::admin.layouts._partials.imagepreview')
<script>
    $(document).ready(function() {
        $('#js-category-id').change(function() {
            let selectedCategoryId = $(this).val()
            $('#js-sub-category-id option').each(function() {
                if ($(this).data('category-id') == selectedCategoryId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#js-sub-category-id').val('');
        });

    });

    @if($updateMode)
    $('#js-category-id').val('{{ $categoryId }}');
    $('#js-sub-category-id').val('{{ $productCategory->subcategory_id }}');
    @endif

</script>
@endpush
