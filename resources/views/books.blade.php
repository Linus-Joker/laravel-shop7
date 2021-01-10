<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vue_product</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body>
    <div id="app">
        {{-- nav start --}}
        <div id="app">
            <nav class="container">
                <div class="row justify-content-around">
                    <p>
                        <a href={{url('/')}}>Home</a>
                    </p>
                    <p>
                        <a href="{{url('/cart')}}">Cart</a>
                    </p>
                </div>
            </nav>
        {{-- nav end --}}

        {{-- top-header start --}}
        <div class="container text-center mt-3">
            <p class="text-justify">
                <h1 class="display-3">Pricing</h1>
                <p class="lead">Quickly build an effective pricing table for your potential customers with this Bootstrap
                    example.
                    It's built with default Bootstrap components and utilities with little customization.</p>
            </p>
        </div>
        {{-- top-header end --}}

        <book-component/>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
