<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        @yield('content')
    </body>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</html>
