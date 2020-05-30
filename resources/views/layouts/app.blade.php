<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MarketPlace L6</title>
    {{-- BOOTSTRAP CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    @include('layouts.includes.navbar')

    <div class="container">

        @include('flash::message')

        @yield('content')

    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')

</body>
</html>