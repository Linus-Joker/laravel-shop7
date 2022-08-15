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

    {{-- Add Model --}}
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
                        <div id="errorMessage" class="alert alert-danger d-none" role="alert"></div>
                        
                        <div class="mb-3">
                            <label for="">product_name</label>
                            <input type="text" name="product_name" class="form-control product_name" required="required"/>
                        </div>
                        <div class="mb-3">
                            <label for="">description</label>
                            <input type="text" name="description" class="form-control description" required="required"/>
                        </div>
                        <div class="mb-3">
                            <label for="">price</label>
                            <input type="text" name="price" class="form-control price" required="required"/>
                        </div>

                        <div class="mb-3">
                            <label for="">pic_file</label>
                            <input type="file" name="pic_file" class="form-control pic_file" required="required"/>
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

        {{-- Edit Model --}}
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">edit Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="editProduct">
                            <div id="errorMessageUpdate" class="alert alert-danger d-none"></div>
                            
                            <input type="hidden" name="product_id" id="product_id" >
                            <div class="mb-3 form-group">
                                <label for="">product_name</label>
                                <input type="text" name="product_name" id="product_name" class="form-control" required="required"/>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="">description</label>
                                <input type="text" name="description" id="description" class="form-control" required="required"/>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="">price</label>
                                <input type="text" name="price" id="price" class="form-control" required="required"/>
                            </div>

                            <div class="mb-3 form-group">
                                <label for="exampleInputPreviewPic">previewPic</label>
                                <img src="" alt="NoPic" class="form-control previewPic">
                            </div>

                            <div class="mb-3 form-group">
                                <label for="">pic_file</label>
                                <input type="file" name="pic_file" id="pic_file" class="form-control pic_file" />
                            </div>
                            {{-- 還有一個產品種類沒放 --}}
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">update</button>
                            </div>
                        </form>
                    </div>
    
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
                            <button id="update" class="btn btn-info editBtn" value="{{ $p->id }}">修改</button>
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
    //新增ajax
    $(document).on('submit', '#addProduct', function (e) {
        e.preventDefault();

        //param
        let name = document.querySelector('.product_name').value;
        let description = document.querySelector('.description').value;
        let price = document.querySelector('.price').value;
        let products_sort_id = 1;
        let pic_file = $('.pic_file').prop('files')[0];

        //formData，整理的資料內容
        let formData = new FormData();
        formData.append('name',name);
        formData.append('description',description);
        formData.append('price',price);
        formData.append('products_sort_id',products_sort_id);
        formData.append('pic_file',pic_file)

        //js整理的資料內容       
        // let data = {
        //     "name":name,
        //     "description":description,
        //     "price":price,
        //     "products_sort_id":products_sort_id
        // };
        // JSON.stringify(data);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'api/v1/admin/products',
            type:'POST',
            data:formData,
            processData: false,
            contentType: false,
            success:function(data){
                //後端傳回來的就是JSON格式，所以不用轉
                if(data.status == 201){
                    $('#errorMessage').addClass('d-none');
                    $('#addModal').modal('hide');
                    $('#addProduct')[0].reset();

                    $('#bookTable').load(location.href + " #bookTable");
                    alert(data.message);
                    console.log(data);
                }else if(data.status == 500){
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(data.message);
                    // alert(data.message);
                }
            }
        });
    });

    //編輯取得資料ajax
    $(document).on('click', '.editBtn', function (e) {
        e.preventDefault();
        let $bookId = $(this).val();

        $.ajax({
            url:"api/v1/admin/products/" + $bookId,
            type:"GET",
            success: function(data){
                if(data.status == 200){
                    $('#product_id').val(data.data.id);
                    $('#product_name').val(data.data.name);
                    $('#description').val(data.data.description);
                    $('#price').val(data.data.price);

                    let image_name = data.data.product_image.image_name;
                    let image_path = data.data.product_image.image_path;
                    let image_src = location.origin + '/' + image_path + '/' + image_name;

                    $('.previewPic').attr('src', image_src);
                    $('#editModal').modal('show');
                }
            }
        });
    });

    //更新ajax
    $(document).on('submit', '#editProduct', function (e) {
        e.preventDefault();

        //param
        let id= document.querySelector('#product_id').value;
        let name = document.querySelector('#product_name').value;
        let description = document.querySelector('#description').value;
        let price = document.querySelector('#price').value;
        let products_sort_id = 1;
        let pic_file = $('#pic_file').prop('files')[0];

        //formData，整理的資料內容
        let formData = new FormData();
        formData.append('name',name);
        formData.append('description',description);
        formData.append('price',price);
        formData.append('products_sort_id',products_sort_id);
        formData.append('pic_file',pic_file);
        formData.append('_method', 'PUT');

        // console.log(pic_file);

        //formData一直傳不了，改成將資料打包好轉json，傳到後端        
        // let data = {
        //     "name":name,
        //     "description":description,
        //     "price":price,
        //     "products_sort_id":products_sort_id
        // };
        // JSON.stringify(data);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'api/v1/admin/products/' + id,
            type:'POST',
            data:formData,
            processData: false,
            contentType: false,
            success:function(data){
                //後端傳回來的就是JSON格式，所以不用轉
                if(data.status == 200){
                    $('#errorMessage').addClass('d-none');
                    $('#editModal').modal('hide');
                    $('#editProduct')[0].reset();

                    $('#bookTable').load(location.href + " #bookTable");
                    alert(data.message);

                }else if(data.status == 500){
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(data.message);
                    // alert(data.message);
                }
            }
        });
    });

    //刪除ajax
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
                    }else if(data.status == 500){
                        alert(data.message);
                    }
                },
                error:function(err){
                    alert(err);
                }
            });
        }

    });
</script>
@endsection
