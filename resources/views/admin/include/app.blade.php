<!DOCTYPE html>
<html lang="zh-TW">
<head>
    @include('admin.include.meta')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.aside')

        @yield('content')

        @include('admin.include.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    @include('admin.include.js')

    @yield('js')

</body>
</html>
