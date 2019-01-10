@extends('layouts.app')
@section('content')

    <div class="artwork-flexbox">

        <div class="artwork-container">
            <a href='{{url("storage/uploads/images/specificImages/".$image->image_file_name)}}'>
                <img class='specific-image' src='{{url("storage/uploads/images/specificImages/".$image->image_file_name)}}' alt='Random image' />
            </a>
            @foreach($subImages as $subImage)
                <a href='{{url("storage/uploads/images/specificImages/".$image->image_file_name)}}'>
                    <img class='specific-image' src='{{url("storage/uploads/images/specificImages/".$subImage->image_file_name)}}' alt='Random image' />
                </a>
            @endforeach
        </div>

        <div class="artwork-info-container">

            <p class='author'>
                <a href='{{ route('profile', $author->username)}}'>
                    <img class='profile-picture' src='{{url("storage/uploads/profile_pictures/edited/".$author->image_file_name)}}'>
                    {{$author->username}}
                </a>
            </p>

            <p class='title'>{{ $image->name }}</p>

            @if(!empty($image->description))
                <p class='description'>{{ $image->description }}</p>
            @endif

            @auth
                <div class="buttons-container">
                    @if ($liked)
                        <button class="submit-btn like liked" id='{{ $image->id }}'><i class="fas fa-check"></i> Liked</button>
                    @else
                        <button class="submit-btn like" id='{{ $image->id }}'><i class="far fa-thumbs-up"></i> Like</button>
                    @endif
                    @if(Auth::id() === $image->user_id || Auth::user()->hasRole('Admin'))
                        <a class='edit-btn edit' href="{{ route('updateArtworkView', $image->id) }}"><i class="far fa-edit"></i> Edit</a>
                    @endif
                </div>
            @endauth

            <div class="stats-container">
                <p class='likes-count'><i class="far fa-thumbs-up fa-fw"></i>{{ $numberOfLikes }} Likes</p>
                <p><i class="far fa-eye fa-fw"></i>{{ $image->views }} Views</p>
                <p class='comments-count'><i class="far fa-comments fa-fw"></i>{{ $commentsCount }} Comments</p>
                <p><i class="fas fa-file-download fa-fw"></i>
                    <a href="{{url("storage/uploads/images/specificImages/".$image->image_file_name)}}" download="{{ $image->name }}">Download</a>
                </p>
            </div>

            @if(count($tags) > 0)
                <div class='tags-container'>
                    <p><i class="fas fa-tags fa-fw"></i>Tags</p>
                    <div>
                        @foreach($tags as $tag)
                            <a class='image-tag' href="{{url('search?q='.$tag->name)}}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(count($recentImages) > 0)
                <p class='more-by-author'>More images by<a href='{{ route('profile', $author->username) }}'>
                    {{ $author->username }}<img class='profile-picture' src='{{url("storage/uploads/profile_pictures/edited/".$author->image_file_name)}}'>
                </a></p>
                <div class="gallery-container">
                    @foreach($recentImages as $recentImage)
                        <a class="gallery-element" href='{{ route('specificImage', $recentImage->id) }}'>
                            <img class='responsive-image' src='{{url("storage/uploads/images/miniImages/".$recentImage->image_file_name)}}' alt='Random image' />
                        </a>
                    @endforeach
                </div>
            @endif

            @if(count($similarImages) > 0)
                <p class='similar-from-category'>Similar images from<a href='{{ route('specificCategory', $image->category->name)}}'>
                    {{ $image->category->name }}<img class='profile-picture' src='{{url("storage/uploads/categories/thumbnails/".$image->category->image_file_name)}}'>
                </a></p>
                <div class="gallery-container">
                    @foreach($similarImages as $similarImage)
                        <a class="gallery-element" href='{{ route('specificImage', $similarImage->id) }}'>
                            <img class='responsive-image' src='{{url("storage/uploads/images/miniImages/".$similarImage->image_file_name)}}' alt='Random image' />
                        </a>
                    @endforeach
                </div>
            @endif

            @auth
                <form class='comment-form' method='POST' action=''>
                    <textarea class='comment-textarea' name='comment'></textarea>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="image_id" value="{{ $image->id }}">
                    <button class='submit-btn post-comment' type='submit' name='commentSubmit'><i class="far fa-comment"></i> Comment</button>
                </form>
            @endauth

            @if(count($comments) > 0)
                <div class='comments-container'>
                    @foreach($comments as $comment)
                        <div class="comment-flexbox">
                            <div class="comment-container">
                                <a href='{{ route('profile', $comment->user->username) }}'>
                                    <img class='comment-picture' src='{{ url("storage/uploads/profile_pictures/edited/".$comment->user->image_file_name )}}'>
                                </a>
                            </div>
                            <div class="comment-info-container">
                                <a href='{{ route('profile', $comment->user->username) }}'>{{ $comment->user->username }}</a>
                                <p>{{ $comment->comment }}</p>
                            </div>
                            <div class="comment-actions-container">
                                @auth
                                    @if(Auth::id() === $comment->user->id || Auth::user()->hasRole('Admin'))
                                        <i class="fas fa-times delete-comment" data-id="{{ $comment->id }}" data-image="{{ $image->id }}"></i>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

<script>
    var token = '{{ Session::token() }}';
    var urlComment = '{{ route('comment') }}';
    var urlDeleteComment = '{{ route('deleteComment') }}';
    var urlLike = '{{ route('likeArtwork') }}';
</script>

@endsection
