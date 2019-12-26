@extends('layouts.app')

@section('title')
Sign In |
@endsection

@section('content')

<div class="wrapper">
    <div class="sign-in-container">
        <form class='centered-form' action='{{ route('signin') }}' method='POST'>
            <p class='page-header'>Sign In</p>
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
            <button class='submit-btn publish' type='submit'>Sign In</button>
            <a class='signUpInA' href='#'>Forgot password?</a>
            <a class='signUpInA' href='{{ route('signup') }}'>Don't have an account? Sign up!</a>

        </form>
    </div>
</div>

@endsection
