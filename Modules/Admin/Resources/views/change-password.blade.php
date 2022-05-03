@extends('layouts.admin')

@section('page_title', 'Edit password')

@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Change password</div>
                    <div class="ibox-tools"></div>
                </div>
                @if(session('message'))
                <div class="alert alert-success">{{session('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="ibox-body">
                    <x-validation-errors></x-validation-errors>

                    <form method="post" action="{{route('update.password')}}" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" class="form-control" name="old_password" value="" placeholder="Enter Old Password">
                            </div>

                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_password" value="" placeholder="Enter New Password">
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" value="" placeholder="Enter Password Again">
                            </div>
                        <br>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
