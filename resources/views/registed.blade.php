<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vue_registed</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body>
    <div id="app">
        {{-- nav start --}}
        <nav class="container">
            <div class="row justify-content-around">
                <p>
                    <a href={{url('/')}}>Home</a>
                </p>
            </div>
        </nav>
        {{-- nav end --}}

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
