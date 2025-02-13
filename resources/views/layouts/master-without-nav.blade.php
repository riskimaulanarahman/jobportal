<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="Career Itci Hutani Manunggal" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/ihm-tp.png')}}">
        @include('layouts.head-css-out')
  </head>

    @yield('body')

    @yield('content')
    @include('components.panduan-modal')
    @include('layouts.vendor-scripts')
    </body>
</html>

