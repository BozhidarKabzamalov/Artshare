@extends('layouts.app')
@section('content')

<div class="wrapper">
    <div class="sign-up-container">
        <form action='{{ route('signup') }}' method='POST'>

            <div class="form-group">
                <label class='label required'>First Name</label>
                <input class='input' type='text' name='firstName' placeholder='First Name' value='{{ Request::old('firstName') }}'>
                @include('partials.invalid', ['field' => 'firstName'])
            </div>

            <div class="form-group">
                <label class='label required'>Last Name</label>
                <input class='input' type='text' name='lastName' placeholder='Last Name' value='{{ Request::old('lastName') }}'>
                @include('partials.invalid', ['field' => 'lastName'])
            </div>

            <div class="form-group">
                <label class='label required'>Username</label>
                <input class='input' type='text' name='username' placeholder='Username' value='{{ Request::old('username') }}'>
                @include('partials.invalid', ['field' => 'username'])
            </div>

            <div class="form-group">
                <label class='label required'>Password</label>
                <input class='input' type='password' name='password' placeholder='Password' value='{{ Request::old('password') }}'>
                @include('partials.invalid', ['field' => 'password'])
            </div>

            <div class="form-group">
                <label class='label required'>Email</label>
                <input class='input' type='text' name='email' placeholder='Email' value='{{ Request::old('email') }}'>
                @include('partials.invalid', ['field' => 'email'])
            </div>

            {{ csrf_field() }}
            <button class='submit-btn' type='submit'>Sign Up</button>

            <a class='signUpInA' href='{{ route('signin') }}'>Already have an account? Sign in!</a>

        </form>
    </div>
</div>

@endsection
