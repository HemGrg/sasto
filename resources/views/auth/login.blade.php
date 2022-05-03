@extends('layouts.app')

@section('content')
<div class="content">
        <div class="brand">
            <p class="link text-capitalize">Welcome<br> to  <a class="link " href="#" >B2B </a> Dashboard</p>
        </div>
        <form id="login-form" action="{{ route('admin.postLogin') }}" method="post">
            @csrf
            <h2 class="login-title">Admin Log in</h2>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control " type="email" name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="email">
                    @error('email')
                        <span class="alert alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            {{--
            <div class="form-group d-flex justify-content-between">
                <label class="ui-checkbox ui-checkbox-info">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="input-span"></span>Remember me</label>
                 
            </div>
            --}}
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit">Login</button>
            </div>
        </form>
    </div>
@endsection
