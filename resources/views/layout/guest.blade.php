<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- Include default global styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Section for page-specific styles --}}
    @yield('custom-styles')
</head>

<body>
    {{-- Default layout content --}}
    @yield('content')

    {{-- Default footer scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Section for page-specific scripts --}}
    @yield('custom-scripts')
</body>

</html>