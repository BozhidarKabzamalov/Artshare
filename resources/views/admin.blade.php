@extends('layouts.app')

@section('title')
Admin Panel |
@endsection

@section('content')

    <div class="wrapper">
        <div class="admin-container">
            <form class='centered-form create-category' action="{{ route('createCategory') }}" method="POST" enctype="multipart/form-data">
                <p class='page-header'>Create Category</p>
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
                <button class='submit-btn publish' type="submit" name="submit">Upload</button>

            </form>

            @if(!empty($categories) && count($categories) > 0)
                <form class='centered-form' method="POST" action="{{ route('deleteCategories') }}">
                <p class='page-header'>Delete Categories</p>
                @foreach($categories as $category)
                    <div class="categories-flexbox">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        <input type="hidden" name="categoryFiles[]" value="{{ $category->image_file_name }}">
                        <img class='profile-picture' src='{{ url("storage/uploads/categories/thumbnails/".$category->image_file_name) }}' alt='Random image' />
                        <p>{{ $category->name }}</p>
                    </div>
                @endforeach
                <button class='delete-btn publish' type="submit">Delete</button>
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
