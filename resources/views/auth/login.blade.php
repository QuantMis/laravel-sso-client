@extends('layouts.app', ['title' => 'SSO Client'])

@section('content')

<div class="col-md-4">
    <div class="card border-0 shadow rounded">
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <h4 class="font-weight-bold">LOGIN CLIENT APP 1</h4>
            <hr>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold text-uppercase">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Input your email address">
                    @error('email')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>    
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Input your password">
                    @error('password')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>    
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                <p class="text-center pt-2">Or</p>
                <a href="{{ route('sso.login') }}" class="btn btn-success btn-block">LOGIN WITH SSO</a>
                <hr>

                <a href="/forgot-password">Fogot Password ?</a>

            </form>
        </div>
    </div>
    <div class="register mt-3 text-center">
        <p>Belum punya akun ? Daftar <a href="/register">Disini</a></p>
    </div>
</div>

@endsection