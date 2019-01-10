@extends('layouts.app')
@section('content')

<div class="profile-container">

    <img class='profile-container-picture' src='{{url("storage/uploads/profile_pictures/edited/".$user->image_file_name)}}'>
    <p class='profile-container-name'>{{$user->first_name}} {{$user->last_name}}</p>

    @if(Auth::user())
        @if(Auth::id() === $user->id)
            <a href='{{url("settings/". $user->username )}}'>Edit Profile</a>
        @endif
    @endif

    @if(!empty($images))
        <div class="profile-images-container">
            @foreach($images as $image)
                <a href='{{ route('specificImage', $image->id)}}'>
                    <img class='profile-images' src='{{ url("storage/uploads/images/miniImages/".$image->image_file_name) }}'>
                </a>
            @endforeach
        </div>
    @endif

    @if(!empty($likedImages))
        <div class="profile-images-container">
            @foreach($likedImages as $likedImage)
                <a href='{{ route('specificImage', $likedImage->id)}}'>
                    <img class='profile-images' src='{{ url("storage/uploads/images/miniImages/".$likedImage->image_file_name) }}'>
                </a>
            @endforeach
        </div>
    @endif

</div>

@endsection
