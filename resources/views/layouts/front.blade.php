<!doctype html>
<html lang="en">

<head>
    @include('includes.front.meta')
    @include('includes.front.style')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ $title ?? 'Laracamp by BuiltWith Angga' }}</title>
</head>

<body>
    @unless(request()->is('login'))
        @include('includes.nav')
    @endunless

    @yield('content')

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    @include('includes.front.script')

</body>

</html>
