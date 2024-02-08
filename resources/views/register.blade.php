@extends('layout/main')

@section('workspace')
<div class="container d-flex align-items-center justify-content-center mt-50">
    <div class="d-flex flex-column">
    <h1 class="text-center">Register</h1>
    @if(Session::has('success'))
    <p style="color: green">
        {{ Session::get('success') }}
    </p>
    @endif
    <form action="{{ route('userRegister') }}" method="post" class="text-center">
        @csrf
        <div class="row mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
            @if ($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif
        </div>
        <div class="row mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
        @if ($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
        </div>
        <div class="row mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
            @if ($errors->has('password'))<span class="text-danger">{{ $errors->first('password') }}</span>@endif
        </div>
        <div class="row mb-3">
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
            @if ($errors->has('confirm_password'))<span class="text-danger">{{ $errors->first('confirm_password') }}</span>@endif
        </div>
        <input type="submit" class="btn btn-primary" value="Register">
    </form>
    </div>
</div>
@endsection
