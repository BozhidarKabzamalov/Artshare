@extends('layouts.app')

@section('title')
Update {{ $image->name }} |
@endsection

@section('content')

    <div class="wrapper">
        <div class="upload-container">
            <form class='centered-form update-form' action="{{ route('updateArtwork', $image) }}" method="POST" enctype="multipart/form-data">
                <p class='page-header'>Edit Artwork</p>
                <div class="form-group">
                    <label class='label required' for="artwork-title">Title</label>
                    <input class='input' type="text" name="artwork-title" placeholder="Title" value='{{ $image->name }}'>
                    @include('partials.invalid', ['field' => 'artwork-title'])
                </div>

                <div class="form-group">
                    <label class='label' for="artwork-description">Description</label>
                    <input class='input' type="text" name="artwork-description" placeholder="Description" value='{{ $image->description }}'>
                    @include('partials.invalid', ['field' => 'artwork-description'])
                </div>

                <div class="form-group">
                    <label class='label' for="artwork-medium">Medium</label>
                    <input class='input' type="text" name="artwork-medium" placeholder="Medium" value='{{ $image->medium }}'>
                    @include('partials.invalid', ['field' => 'artwork-medium'])
                </div>

                <div class="form-group">
                    <label class='label' for="artwork-software">Used Software</label>
                    <input class='input' type="text" name="artwork-software" placeholder="Used Software" value='{{ $image->software }}'>
                    @include('partials.invalid', ['field' => 'artwork-software'])
                </div>

                @if (!$categories->isEmpty())
                    <div class="form-group">
                        <label class='label required' for="artwork-category">Category</label>
                        <select class='category-select' name='artwork-category' value='{{ Request::old('artwork-category') }}'>
                            @foreach($categories as $category)
                                <option value='{{$category->id}}'>{{$category->name}}</option>
                            @endforeach
                        </select>
                        @include('partials.invalid', ['field' => 'artwork-category'])
                    </div>
                @endif

                <div class="form-group">
                    <label class='label' for="artwork-tags">Tags</label>
                    <input class='input' type="text" name="artwork-tags" placeholder="Tags" value='{{ $tagString }}'>
                    @include('partials.invalid', ['field' => 'artwork-tags'])
                </div>

                {{ method_field('patch') }}
                {{ csrf_field() }}

                <button class='submit-btn publish' type="submit" name="submit">Save</button>

            </form>

            @if(Auth::user())
                @if(Auth::id() === $image->user_id || Auth::user()->hasRole('Admin'))
                    <form class='centered-form' method="POST" action="{{route('DeleteArtwork', $image->id)}}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button class='delete-btn publish' type="submit">Delete Image</button>
                    </form>
                @endif
            @endif

        </div>
    </div>

@endsection
