<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts._meta')
    @include('layouts._scripts')
    @include('layouts._fonts')
    @include('layouts._styles')

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
</head>
<body>
    <div id="app">
        @include('layouts._nav')

        <main class="py-lg-4 container">
            @yield('content')
        </main>
    </div>
</body>
</html>
