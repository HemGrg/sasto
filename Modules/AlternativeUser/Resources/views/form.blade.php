@extends('layouts.admin')

@section('page_title')
Users
@endsection

@section('content')
<div class="page-content container fade-in-up" style="max-width: 600px;">

    <div class="mb-3">
        <a href="{{ route('alternative-users.index') }}" class="btn btn-primary border-0">Back to listing</a>
    </div>

    <x-validation-errors></x-validation-errors>

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ $updateMode ? 'Update' : 'Add' }} User</div>
            <div class="ibox-tools">
            </div>
        </div>

        <div class="ibox-body">
            <form id="subcategory-create-form" action="{{ $updateMode ? route('alternative-users.update', $alternativeUser->id) : route('alternative-users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($updateMode)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $alternativeUser->id }}">
                @endif
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $alternativeUser->name) }}" placeholder="Enter name">
                    <x-invalid-feedback field="name" />
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $alternativeUser->email) }}" placeholder="Enter email">
                    <x-invalid-feedback field="email" />
                </div>

                <div class="form-group">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile', $alternativeUser->mobile) }}" placeholder="Enter mobile">
                    <x-invalid-feedback field="mobile" />
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Enter password">
                    <small class="form-text">Leave empty if you don't want to update.</small>
                    <x-invalid-feedback field="password" />
                </div>

                <div class="form-group">
                    <label>Permissions</label>
                    <div class="check-list">
                        @foreach($permissions as $key => $permission)
                        <label class="ui-checkbox ui-checkbox-primary">
                            <input name="permissions[]" type="checkbox" value="{{ $key }}" @if($alternativeUser->hasPermission($key)) checked @endif>
                            <span class="input-span"></span>{{ $permission }}
                        </label>
                        @endforeach
                    </div>
                    <x-invalid-feedback field="name" />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg border-0 px-5">Submit</button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
