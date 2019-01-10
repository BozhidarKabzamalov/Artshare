@extends('layouts.app')
@section('content')

<div class="wrapper">
    <div class="sign-in-container">
        <form action='{{ route('signin') }}' method='POST'>

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

            {{ csrf_field() }}
            <button class='submit-btn' type='submit'>Sign In</button>
            <a class='signUpInA' href='#'>Forgot password?</a>
            <a class='signUpInA' href='{{ route('signup') }}'>Don't have an account? Sign up!</a>

        </form>
    </div>
</div>

@endsection
