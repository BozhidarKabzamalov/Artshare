@extends('layouts.app')
@section('content')

    <div class="wrapper">
        <div class="admin-container">
            <form action="{{ route('createCategory') }}" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label class='label required' for="categoryName">Category Name</label>
                    <input class='input' type="text" name="categoryName" placeholder="Category Name" value='{{ Request::old('categoryName') }}'>
                    @include('partials.invalid', ['field' => 'categoryName'])
                </div>

                <div class="form-group">
                    <div class="upload-btn-wrapper">
                        <button class="btn">Drop files here or click to upload</button>
                        <input class='upload-input' type="file" name='categoryImage'>
                        @include('partials.invalid', ['field' => 'categoryImage'])
                    </div>
                </div>

                {{ csrf_field() }}
                <button class='submit-btn' type="submit" name="submit">Upload</button>

            </form>

            @if(!empty($categories) && count($categories) > 0)
                <form method="POST" action="{{ route('deleteCategories') }}">
                @foreach($categories as $category)
                    <!--<div class="categories-flexbox">
                        <img class='profile-picture' src='{{ url("storage/uploads/categories/thumbnails/".$category->image_file_name) }}' alt='Random image' />
                        <p>{{ $category->name }}</p>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        <input type="hidden" name="categoryFiles[]" value="{{ $category->image_file_name }}">
                    </div>-->
                    <div class="categories-wrapper">
                        <img src='{{ url("storage/uploads/categories/thumbnails/".$category->image_file_name) }}' alt='Random image' />
                        <input class='category-input' type="checkbox" name="categories[]" value="{{ $category->id }}">
                        <label></label>
                        <input type="hidden" name="categoryFiles[]" value="{{ $category->image_file_name }}">
                    </div>
                @endforeach
                <button class='delete-btn' type="submit">Delete</button>
                {{ csrf_field() }}
                {{ method_field('delete') }}
                </form>
            @endif
        </div>
    </div>

    <script>
        var token = '{{ Session::token() }}';
    </script>

@endsection
