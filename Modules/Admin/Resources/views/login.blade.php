@extends('layouts.app')

@push('styles')
<style>
    #admin-login-card button[type="submit"] {
        background-color:#1d75bd;
    }
    @media screen AND (min-width: 768px) {
        #admin-login-card {
            min-width: 400px;
        }
    }

</style>
@endpush

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #1d75bd;">
    <div id="admin-login-card" class="card">
        <div class="card-body px-md-5">
            <div class="text-center">
                <a href="/">
                    <img src="/images/logo.png" alt="Sasto Wholesale" style="max-height: 4rem;">
                </a>
                <h4 class="h4-responsive my-4"><strong>Admin Log in</strong></h4>
            </div>
            <form action="/admin/login" method="POST">
                @csrf
                @error('login')
                <div class="border py-2 px-3 rounded text-danger mb-2" style="background-color: #ffd6d6; border-color: #ff8c97!important;">
                    {{ $message }}
                </div>
                @enderror
                <div class="form-group">
                    <div class="input-group-icon right">
                        <div class="input-icon"><i class="fa fa-envelope"></i></div>
                        <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group-icon right">
                        <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                        <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block btn-lg border-0">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
