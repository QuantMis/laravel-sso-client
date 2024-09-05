@extends('layouts.app')

@section('content')

    <div class="col-md-10">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <h1>Home Client 1 APP</h1>
                Selamat Datang <strong>{{ auth()->user()->name }}</strong>
                <hr>
                <a href="{{ route('logout') }}" style="cursor: pointer" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="btn btn-md btn-primary">LOGOUT</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

@endsection