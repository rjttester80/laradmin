@extends('layout/main')

@section('workspace')
<div class="container d-flex align-items-center justify-content-center">
    <div class="d-flex flex-column">
    <h1 class="text-center">Login</h1>
    @if(Session::has('success'))
    <p style="color: green">
        {{ Session::get('success') }}
    </p>
    @endif
    @if(Session::has('error'))
    <p style="color: red">
        {{ Session::get('error') }}
    </p>
    @endif
    <form action="{{ route('adminLogin') }}" method="post" class="text-center">
        @csrf
        <div class="row mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
        @if ($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
        </div>
        <div class="row mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
            @if ($errors->has('password'))<span class="text-danger">{{ $errors->first('password') }}</span>@endif
        </div>
        <input type="submit" class="btn btn-primary" value="Login">
    </form>
    </div>
</div>
@endsection
