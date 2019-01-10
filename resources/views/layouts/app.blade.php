<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name', 'Laravel App')}}</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>

    <nav class='navigation'>
        <div class="wrapper">
            <ul class="navigation-ul">
                <li class='dropdown'>
                    <a href='#'>
                        <img src='{{ url("storage/uploads/icons/dropdown.png") }}'>
                    </a>
                </li>
                <li class='{{ Route::currentRouteNamed('home') ? 'currentURL' : '' }}'>
                    <a href="{{ route('home') }}">Images</a>
                </li>
                <li class='{{ Route::currentRouteNamed('categories') ? 'currentURL' : '' }}'>
                    <a href="{{ route('categories') }}">Categories</a>
                </li>
                @auth
        		<li class='{{ Route::currentRouteNamed('upload') ? 'currentURL' : '' }}'>
                    <a href="{{ route('upload') }}">Upload</a>
                </li>
        		@if (Auth::user()->hasRole('Admin'))
        		<li class='{{ Route::currentRouteNamed('admin') ? 'currentURL' : '' }}'>
                    <a href="{{ route('admin') }}">Admin Panel</a>
                </li>
        		@endif
        		@endauth
                <li>
                    <form action="{{ Route('search') }}" method='GET'>
                        <input type="text" placeholder="Search" name="q" autocomplete="off">
                    </form>
                </li>
                @guest
                <li class='{{ Route::currentRouteNamed('signInView') ? 'currentURL' : '' }}'>
                    <a href="{{ route('signInView') }}">Sign In</a>
                </li>
        		<li class='{{ Route::currentRouteNamed('signUpView') ? 'currentURL' : '' }}'>
                    <a href="{{ route('signUpView') }}">Sign Up</a>
                </li>
        		@endguest
                @auth
                <li class='{{ Route::currentRouteNamed('profile') ? 'currentURL' : '' }}'>
                    <a class='navigation-username' href='{{url("profile/".Auth::user()->username )}}'>
                        <img class='profile-picture' src='{{url("storage/uploads/profile_pictures/edited/".Auth::user()->image_file_name)}}'>
                        <p>{{ Auth::user()->username }}</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">Logout</a>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    @yield('content')
    <script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/javascript.js') }}"></script>
    </body>
</html>
