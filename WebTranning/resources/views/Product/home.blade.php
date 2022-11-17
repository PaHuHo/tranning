@extends("layout/layout")
@section("name-page")
<title>Product</title>
@endsection

@section("name-content")
<h3>Danh sách sản phẩm</h3>
@endsection

@section("main-content")
<form style="margin:10px;" id="formSearchProduct" method="get" action="{{route('search-product')}}">
    @csrf
    <div class="row">
        <div class="col">
            <label for="product_name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="product_name" placeholder="Nhập tên sản phẩm" name="product_name">
        </div>
        <div class="col">
            <label for="is_sales" class="form-label">Trạng thái</label>
            <select id="is_sales" class="form-control" name="is_sales">
                <option value="">Chọn trạng thái</option>
                <option value="1">Đang bán</option>
                <option value="0">Ngừng bán</option>
            </select>
        </div>
        <div class="col">
            <label for="price_min" class="form-label">Giá bán từ</label>
            <input type="text" class="form-control" id="price_min" name="price_min">
        </div>
        <div class="col">
            <label for="price_max" class="form-label">Giá bán đến</label>
            <input type="text" class="form-control" id="price_max" name="price_max">
        </div>
    </div>
    <br>
    <div class="row">
        <!-- <div class="col">
            <a class="btn btn-primary" id="create_product" data-toggle="modal" data-target="#createForm"><i class="fa fa-user-plus"></i>Thêm mới</a>
        </div> -->
        <div class="col">
            <a class="btn btn-primary" id="create_product" href="{{route('add-product')}}"><i class="fa fa-user-plus"></i>Thêm mới</a>
        </div>
        <div class="col-3">
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-labeled btn-primary">
                        <i class="fa fa-search"></i>Tìm kiếm</button>
                </div>
                <div class="col-4 delete-search">
                    <a class="btn btn-primary">
                        <i class="fa fa-times"></i>Xóa tìm</a>
                </div>
            </div>

        </div>
    </div>
</form>
<div id="table_data">
    @include('Product/product-data')
</div>

<input id="hidden_page" value="1" type="hidden" name="hidden_page">

<!-- Modal -->
<!-- <div class="modal fade" id="createForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="Post" action="{{route('store-login')}}">
                    @csrf
                    <div class="row">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa fa-user " aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="email" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                    </div>
                    
                    <br>
                    <div class="row">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa fa-lock " aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="password" placeholder="Password" aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                    </div>                   
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="rememberCheck" value="1">
                                <label class="form-check-label">Remember me</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary" style="margin-left: 13px;">Đăng nhập</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div> -->
@endsection
@section("js-content")
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $("#hidden_page").val(page);
            var producName = $('#product_name').val();
            $select = document.querySelector('#is_sales');
            var isSales = $select.value;
            var maxPrice = $("#price_max").val();
            var minPrice = $("#price_min").val();

            fetchData(page, producName, isSales, minPrice, maxPrice);
        });
        $(document).on('click', '.delete-search a', function(event) {
            event.preventDefault();
            var page = 1
            $("#product_name").text("");
            $("#product_name").val("");
            $select = document.querySelector('#is_sales');
            $select.text = 'Chọn trạng thái';
            $select.value = '';
            $("#price_min").text("");
            $("#price_min").val("");
            $("#price_max").text("");
            $("#price_max").val("");
            fetchData(page, "", "", "", "");
        });
        $('#formSearchProduct').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formSearchProduct').serialize();
            var producName = $('#product_name').val();
            $select = document.querySelector('#is_sales');
            var isSales = $select.value;
            var maxPrice = $("#price_max").val();
            var minPrice = $("#price_min").val();
            var page = 1;
            fetchData(page, producName, isSales, minPrice, maxPrice);
        });
        $(document).on('click', '._delete_data', function() {
            var id = $(this).data("id");
            var url = $(this).data('url').split('&name=')[0];
            var name = $(this).data('url').split('name=')[1];
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "Nhắc nhở",
                text: "Bạn có muốn xóa sản phẩm " + name.toUpperCase() + " không",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "Green",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }).then(isConfirmed => {
                if (isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function(data) {
                            if (data.status) {
                                swal({
                                    title: data.message,
                                    type: data.status,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    timer: 1500,
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                console.log(data.status);
                                swal("Delete!", data.message, "error");
                            }
                        }
                    });
                }
            });
        });

    });

    function fetchData(page, productName, isSales, minPrice, maxPrice) {
        $.ajax({
            url: "{{route('fetch-data-product')}}" + "?page=" + page + "&product_name=" + productName + "&is_sales=" + isSales + "&price_min=" + minPrice + "&price_max=" + maxPrice,
            success: function(data) {
                $('#table_data').html('');
                $('#table_data').html(data);
            }
        });
    }
</script>
@endsection

<!-- <div class="row" style="margin:5px ;">
            <div class="col">
                <h3>Danh sách sản phẩm</h3>
            </div>
            <div class="col-1">
                <a href="">Sản phẩm</a>
            </div>
        </div> -->