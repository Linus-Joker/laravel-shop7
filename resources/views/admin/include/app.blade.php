<!DOCTYPE html>
<html lang="zh-TW">
<head>
    @include('admin.include.meta')
</head>
<body>
    {{-- header nav --}}
    @include('admin.include.header')
    <div class="container-fluid">
        <div class="row">
            {{-- aside --}}
            @include('admin.include.aside')
            {{-- content --}}
            @yield('content')
        </div>
    </div>
    @include('admin.include.footer')

    @include('admin.include.js')
    @yield('js')
</body>
</html>
