<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
     <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <script src="{{asset ('js/bootstrap.bundle.min.js')}}"></script>
    <title>React Practice</title>

    {{-- React development support --}}
    @viteReactRefresh

    {{-- Load only our new React entry point --}}
    @vite('resources/js/react-app.jsx')
</head>
<body>
<x-navbar/>
    <div id="react-root"></div>
<x-footer/>
</body>
</html>