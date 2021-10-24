<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product_page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div id="app">
        {{-- nav start --}}
        <div>
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
        </div>    
        {{-- nav end --}}

        <p>產品ID:{{ $product_id }}</p>
        {{-- 要從 blade 傳遞外部參數進vue component --}}
        <productpage-component :product_id="{{ $product_id }}"></productpage-component>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>