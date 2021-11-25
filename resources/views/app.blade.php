<!DOCTYPE html>
<html lang="en">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Medium App</title>
        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <style type="text/css">
            .card .card-content .card-title {
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: -moz-hidden-unscrollable;
            }
            span.badge {
                float: left !important;
            }
        </style>
    </head>
    <body>
        @if (Auth::check())
            <script>
                window.General = {!!json_encode([
                    'LoggedIn' => true,
                    'user' => Auth::user()
                ])!!}
            </script>
        @else
            <script>
                window.General = {!!json_encode([
                    'LoggedIn' => false
                ])!!}
            </script>
        @endif
        <div id="app">
        </div>
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>