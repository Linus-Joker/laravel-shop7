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
        <nav class="container navbar navbar-expand-lg navbar-light bg-light">
            <div class="row justify-content-around">
                <p>
                    <a class="navbar-brand mb-0 h1" href={{url('/')}}>Home</a>
                </p>
                <p>
                    <a class="navbar-brand" href="{{url('/cart')}}">Cart</a>
                </p>

                @if ($userNumber == null)
                <a class="navbar-brand" href="{{url('/login')}}">登入</a>
                    
                    {{ $userNumber }}
                @else
                <a class="navbar-brand" href="{{url('api/v1/member/logout')}}">登出</a>
                @endif
            </div>
        </nav>
        {{-- nav end --}}

        {{-- top-header start --}}
        <div class="container text-center mt-3">
            <p class="text-justify">
                <h1 class="display-3">Shopcart Practice.</h1>
                {{-- <p class="lead">Quickly build an effective pricing table for your potential customers with this Bootstrap
                    example.
                    It's built with default Bootstrap components and utilities with little customization.</p> --}}
            </p>
        </div>
        {{-- top-header end --}}

        <book-component/>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
