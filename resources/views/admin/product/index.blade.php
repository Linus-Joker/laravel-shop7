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

    {{-- 新增 Model --}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="addProduct">
                    <div class="modal-body">
                        <div id="errorMessage" class="alert alert-warning d-none"></div>

                        <div class="mb-3">
                            <label for="">product_name</label>
                            <input type="text" name="product_name" class="form-control product_name" />
                        </div>
                        <div class="mb-3">
                            <label for="">description</label>
                            <input type="text" name="description" class="form-control description" />
                        </div>
                        <div class="mb-3">
                            <label for="">price</label>
                            <input type="text" name="price" class="form-control price" />
                        </div>
                        {{-- 還有一個產品種類沒放 --}}
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    {{-- 主標題 --}}
    <h4 class="text-primary">AJAX CRUD Book Product using Bootstrap Modal</h4>
    <button id="create" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
        新增
    </button>


    <table id="bookTable" class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">product_name</th>
                <th scope="col">description</th>
                <th scope="col">price</th>
                <th scope="col">操作</th>
                
            </tr>
        </thead>

            @foreach ($products as $p)
                <tbody>
                    <tr>
                        <td>#</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->description }}</td>
                        <td>{{ $p->price }}</td>
                        <td>
                            <button id="update" class="btn btn-warning editBtn" value="{{ $p->id }}">修改</button>
                            <button id="delete" class="btn btn-danger deleteBtn" value="{{ $p->id }}">刪除</button>
                        </td>
                    </tr>
                </tbody>
            @endforeach

    </table>
</div>
@endsection

@section('js')
<script>
    $(document).on('submit', '#addProduct', function (e) {
        e.preventDefault();

        //param
        let name = document.querySelector('.product_name').value;
        let description = document.querySelector('.description').value;
        let price = document.querySelector('.price').value;
        let products_sort_id = 1;

        //formData一直傳不了，改成將資料打包好轉json，傳到後端        
        let data = {
            "name":name,
            "description":description,
            "price":price,
            "products_sort_id":products_sort_id
        };
        JSON.stringify(data);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'api/v1/admin/products',
            type:'POST',
            data:data,
            success:function(data){
                //後端傳回來的就是JSON格式，所以不用轉
                if(data.status == 201){
                    $('#errorMessage').addClass('d-none');
                    $('#addModal').modal('hide');
                    $('#addProduct')[0].reset();

                    $('#bookTable').load(location.href + " #bookTable");
                    alert(data.message);

                }else if(data.sratus == 500){
                    alert(data.message);
                }
            }
        });
    });

    $(document).on('click', '.deleteBtn', function(e){
        e.preventDefault();

        if(confirm('Are you sure delete list??')){
            let id= $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"api/v1/admin/products/" + id,
                type:"DELETE",
                data:id,
                success: function(data){
                    if(data.status == 204){
                        $('#bookTable').load(location.href + " #bookTable");
                        alert(data.message);
                    }
                }
            });
        }

    });


    $(function(){
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
