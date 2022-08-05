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
    <h4 class="text-primary">book table</h4>
    <button id="create" class="btn btn-primary">新增</button>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">product_name</th>
                <th scope="col">description</th>
                <th scope="col">price</th>
                <th scope="col">更新</th>
                <th scope="col">刪除</th> 
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>book1</td>
                <td>123</td>
                <td>100</td>
                <td>
                    <button id="update" class="btn btn-warning">修改</button>
                </td>
                <td>   
                    <button id="delete" class="btn btn-danger">刪除</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@section('js')
<script>
    $(function(){

        //新增應該會是另外的介面，這裡給更新和刪除
        $("#update").click(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'api/v1/admin/products',
                
                //應該給put，但是我忘記怎麼給
                type:'put',
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
