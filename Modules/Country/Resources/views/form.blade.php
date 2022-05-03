@extends('layouts.admin')
@section('page_title') {{ (@$updateMode) ? "Update" : "Add"}} Country @endsection

@section('content')
<div class="page-heading">
    <h1 class="page-title"> Country</h1>
</div>
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ($updateMode) ? "Update" : "Add"}} Country</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('country.index')}}">All Country</a>
            </div>
        </div>
    </div>

    <form class="form form-responsive form-horizontal" action="{{ $updateMode ? route('country.update', $country->id) : route('country.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        @if($updateMode)
        @method('PUT')
        {{-- <input type="hidden" name="_method" value="PUT"> --}}
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Country Information</div>
                            </div>
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Country Name *</strong></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $country->name) }}" name="name" placeholder="Country Name here">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="form-group">
                                    <label> Upload Flag </label>
                                    <input type="file" name="flag" id="image" class="form-control-file @error('flag') is-invalid @enderror" accept="image/*" onchange="handleUploadPreview()" data-preview-el-id="js-country-img-preview">
                                    <small class="form-text">Recommended image size: 400x400px</small>
                                    <img id="js-country-img-preview" class="rounded my-2" src="{{ $country->path ? $country->flagUrl() : 'https://dummyimage.com/400x400/e8e8e8/0011ff' }}" style="max-height: 200px;">
                                    @error('flag')
                                    <div class="invalid-feedback">{{$errors->first('flag')}}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="check-list">
                                        <label class="ui-checkbox ui-checkbox-primary">
                                            <input name="publish" id="publish" type="checkbox" @if(old('publish',$country->publish)) checked @endif>
                                            <span class="input-span"></span>Publish</label>
                                    </div>
                                    @error('publish')
                                    <span class="alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success px-4 border-0" type="submit"><i class="fa-solid fa-paper-plane mr-2"></i>Save</button>
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
