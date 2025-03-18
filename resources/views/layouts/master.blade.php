<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISsM1mGnG6tSdeWrWZz8zW8jrlDjAJRLS2ymKZyA5BvKu3H1zjU6b" crossorigin="anonymous">

        <!-- Styles / Scripts -->
        <link rel="stylesheet" href="../../css/app.css">
     @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
   
        @yield('content')
  
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-7VpZZhCQlATxM2pUsVW1pHN9Fsr0BF+OVKwxH96+K6EOb46U9sLRm+PkmY2bBkwr" crossorigin="anonymous"></script>

</html>