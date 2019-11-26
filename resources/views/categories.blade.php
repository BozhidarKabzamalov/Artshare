@extends('layouts.app')

@section('title')
Categories |
@endsection

@section('content')

<div class="category-container">
    @foreach($categories as $category)
        <div class="category-container-element">
            <a href='{{ route('specificCategory', $category->name) }}'>
                <img class='centered-image' src='{{ url("storage/uploads/categories/thumbnails/".$category->image_file_name) }}' alt='Random image'/>
                <p class='category-title'>{{ $category->name }}</p>
            </a>
        </div>
    @endforeach
</div>

@endsection
