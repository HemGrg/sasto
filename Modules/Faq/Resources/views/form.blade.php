@extends('layouts.admin')
@section('page_title') {{ (@$updateMode) ? "Update" : "Add"}} Faq @endsection

@section('content')
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ($updateMode) ? "Update" : "Add"}} Faq</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('faq.index')}}">All Faq</a>
            </div>
        </div>
    </div>

    <form class="form form-responsive form-horizontal" action="{{ $updateMode ? route('faq.update', $faq->id) : route('faq.store') }}" enctype="multipart/form-data" method="POST">
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
                                <div class="ibox-title">Faq Information</div>
                            </div>
                            <div class="ibox-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label><strong>Faq Title *</strong></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $faq->title) }}" name="title" placeholder="faq Title here">
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label for=""><strong>Description</strong></label>
                                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="short Description here" style="resize:none;">{{ $faq->description }}</textarea>
                                        @error('description')
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
                                    <label><strong>Position *</strong></label>
                                    <input type="number" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $faq->position) }}" name="position" placeholder="faq position here">
                                    @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="check-list">
                                        <label class="ui-checkbox ui-checkbox-primary">
                                            <input name="is_active" id="is_active" type="checkbox" @if(old('is_active',$faq->is_active)) checked @endif>
                                            <span class="input-span"></span>Is Active</label>
                                    </div>
                                    @error('is_active')
                                    <span class="alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-paper-plane mr-2"></i>Save</button>
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
<?php
$name = ['description'];
?>
@push('push_scripts')
<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
@foreach ($name as $data)
@include('dashboard::admin.layouts._partials.ckdynamic', ['name' => $data])
@endforeach
@endpush