@extends('layouts.app')

@section('title')
Settings {{ $user->username }} |
@endsection

@section('content')

<div class="wrapper">
    <div class='settings-container'>
        <form method="post" action="{{ route('updateProfile', $user) }}" enctype="multipart/form-data">

            <div class='form-group'>
                <label class='label' for="first_name">First name</label>
                <input class='input' type="text" name="first_name" value="{{ $user->first_name }}" />
                @include('partials.invalid', ['field' => 'first_name'])
            </div>

            <div class='form-group'>
                <label class='label' for="last_name">Last name</label>
                <input class='input' type="text" name="last_name" value="{{ $user->last_name }}" />
                @include('partials.invalid', ['field' => 'last_name'])
            </div>

            <div class='form-group'>
                <label class='label' for="email">Email</label>
                <input class='input' type="email" name="email" value="{{ $user->email }}" />
                @include('partials.invalid', ['field' => 'email'])
            </div>

            <div class="new-avatar-container">
                <img class='new-avatar-picture' src='{{url("storage/uploads/profile_pictures/edited/".$user->image_file_name)}}'>
                <div class="upload-btn-wrapper">
                    <button class="btn"><i class="fas fa-file-upload"></i> Select a new avatar</button>
                    <input class='new-avatar' type="file" name="file">
                </div>
            </div>

            {{ csrf_field() }}
            {{ method_field('patch') }}

            <button class='submit-btn' type="submit" name="submit">Save</button>

        </form>
    </div>
</div>

@endsection
