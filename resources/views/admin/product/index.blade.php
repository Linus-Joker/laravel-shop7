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
    <button id="create" class="btn btn-primary">新增</button>
    <button id="update" class="btn btn-warning">修改</button>
    <button id="delete" class="btn btn-danger">刪除</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">product_name</th>
                <th scope="col">description</th>
                <th scope="col">price</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@endsection

@section('js')
<script>
    $(function(){
        $("#create").click(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'api/v1/admin/products',
                type:'post',
                data:{
                    name:'book5'
                },
                success:function(data){
                    // var obj = jQuery.parseJSON(data);
                    console.log(data);
                    // alert(data.status);
                }
            });
        });
    });
</script>
@endsection
