<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Wishlist</title>
        <link rel="icon" href="images/favicon.svg" sizes="any" type="image/svg+xml">
        @vite('resources/app.js')
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased">
        <div id="app"></div>
    </body>
</html>
