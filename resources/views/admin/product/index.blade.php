@extends('admin.include.app')
@section('content')

<!-- 中間部分 -->

<div class="col-10 col-sm-10">
    {{-- 麵包削 --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('webadm/index')}}">HOME</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                產品管理
            </li>
        </ol>
    </nav>
    {{-- 主標題 --}}
    <h4 class="text-primary">table</h4>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@section('js')
<script>
    $(function(){
        alert(45646);
    });
</script>
@endsection
