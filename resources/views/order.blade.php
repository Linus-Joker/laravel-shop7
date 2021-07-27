<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vue_order</title>
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
                <p>
                    登出
                </p>
            </div>
        </nav>
        {{-- nav end --}}
        {{-- <order-component/> --}}

        <section class="container mx-auto">
            <h1 class="">Order Page</h1>
            <h3 class="">Order Info</h3>
            <table class="table">
              <thead class="text-center">
                <th class="px-4 py-2">產品名稱</th>
                <th class="px-4 py-2">價格</th>
                <th class="px-4 py-2">數量</th>
                <th class="px-4 py-2">Total</th>
              </thead>
              <tbody class="text-center">
                @foreach ($products as $p)
                <tr>
                  <th scope="row">{{$p['item']['title']}}</th>
                  <td>{{$p['item']['price']}}元</td>
                  <td>{{$p['qty']}}</td>
                  <td class="border px-4 py-2"> {{$p['qty'] * $p['item']['price']}}元</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <p>總金額:{{ $totalPrice }}元</p>
        
            <h3 class="">User Info</h3>
        
            <form method="POST" action="{{url('/orders')}}" class="">
                @csrf
              <div class="mb-3">
                <label class="mb-2" for="name"> Name: </label>
                <input
                  class="border rounded py-2 px-3"
                  name="name"
                  id="name"
                  type="text"
                  placeholder="name"
                />
              </div>
              <div class="mb-3">
                <label class="mb-2" for="email"> Email: </label>
                <input
                  class="border rounded py-2 px-3"
                  name="email"
                  id="email"
                  type="email"
                  placeholder="email"
                />
              </div>
              <div class="d-flex justify-content-between">
                <button
                  class="btn btn-primary text-white py-2 px-4 rounded"
                  type="submit"
                >
                  Submit Order
                </button>
                
              </div>
            </form>
          </section>


    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
