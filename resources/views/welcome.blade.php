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
    <div class="container">
    <div class="login-container">
        <div class="login-wrapper">
            <div class="title-wrap">
                <div class="logo-wrap">
                <img src="{{ asset('/build/images/designkarkhana_logo.jpg') }}" alt="Logo">

                    <!-- <img src= '../../images/' alt=""> -->
                </div>
                <h3>Football scoring System</h3>
            </div>
            <div class="login-box">
                <h4>Login</h4>
                <form>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>

        </div>
    </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-7VpZZhCQlATxM2pUsVW1pHN9Fsr0BF+OVKwxH96+K6EOb46U9sLRm+PkmY2bBkwr" crossorigin="anonymous"></script>

</html>
