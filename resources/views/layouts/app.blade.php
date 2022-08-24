<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HPT</title>

    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="bg-gray-100" x-data="window.clickROI()" @isset($data) x-init='setROIs({!! json_encode($data) !!})' @endisset x-on:keydown.space.prevent="togglePlayPause()" @mouseup="mousedown = false">
    <x-small-screens-notice />

    <div class="container hidden max-w-screen-xl mx-auto xl:block">
        @yield('content')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
