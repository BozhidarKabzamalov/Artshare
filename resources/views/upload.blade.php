@extends('layouts.app')
@section('content')

<div class="wrapper">
    <div class="upload-container">
        <form action="{{ route('uploadArtwork') }}" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class='label required' for="artwork-title">Title</label>
                <input class='input' type="text" name="artwork-title" placeholder="Title" value='{{ Request::old('artwork-title') }}'>
                @include('partials.invalid', ['field' => 'artwork-title'])
            </div>

            <div class="form-group">
                <label class='label' for="artwork-description">Description</label>
                <input class='input' type="text" name="artwork-description" placeholder="Description" value='{{ Request::old('artwork-description') }}'>
                @include('partials.invalid', ['field' => 'artwork-description'])
            </div>

            <div class="form-group">
                <label class='label' for="artwork-medium">Medium</label>
                <input class='input' type="text" name="artwork-medium" placeholder="Medium" value='{{ Request::old('artwork-medium') }}'>
                @include('partials.invalid', ['field' => 'artwork-medium'])
            </div>

            <div class="form-group">
                <label class='label' for="artwork-software">Used Software</label>
                <input class='input' type="text" name="artwork-software" placeholder="Used Software" value='{{ Request::old('artwork-software') }}'>
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
                <input class='input' type="text" name="artwork-tags" placeholder="Tags" value='{{ Request::old('artwork-tags') }}'>
                @include('partials.invalid', ['field' => 'artwork-tags'])
            </div>

            <div class="form-group">
                <div class="upload-btn-wrapper">
                    <button class="btn">Drop files here or click to upload</button>
                    <input class='upload-input' type="file" name='files[]' multiple>
                    @include('partials.invalid', ['field' => 'files'])
                </div>
            </div>

             {{ csrf_field() }}
            <button class='submit-btn' type="submit" name="submit">Publish</button>

        </form>
    </div>
</div>

@endsection
