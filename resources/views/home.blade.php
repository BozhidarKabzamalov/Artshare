@extends('layouts.app')
@section('content')

<div class="home-container">
    @foreach($images as $image)
        <div class="home-container-element">
            <a href='{{route('specificImage', $image->id)}}'>
                <img class='home-image' src='{{url("storage/uploads/images/thumbnails/".$image->image_file_name)}}' alt='Random image'/>
            </a>
        </div>
    @endforeach
</div>

@endsection
