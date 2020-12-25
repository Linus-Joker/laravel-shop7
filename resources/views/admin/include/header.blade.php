<!-- header -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">what後台管理</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link btn btn-dark text-light" href="{{ url('/') }}">回到前台 <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        @if(session('user'))
            <span class="navbar-text">管理員名稱:{{ session('user')}}</span>
        @else
            <span class="navbar-text">管理員名稱:none</span>
        @endif

        <span class="navbar-text ml-3">
            <a href="{{ url('webadm/logout') }}">登出</a>
        </span>
    </div>
</nav>
