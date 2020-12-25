@extends('admin.include.app')
@section('content')

<!-- 中間部分 -->
<div class="col-10 col-sm-10">
    {{-- 麵包削 --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('webadm')}}">HOME</a>
            </li>
        </ol>
    </nav>
    {{-- 主標題 --}}
    <h4 class="text-primary">Dashboard</h4>
</div>
@endsection
