@extends("layout/layout")
@section("name-page")
<title>Customer</title>
@endsection

@section("name-content")
<h3>Danh sách khách hàng</h3>
@endsection

@section("main-content")
<form style="margin:10px;" id="formSearchCustomer" method="get" action="">
    @csrf
    <div class="row">
        <div class="col">
            <label for="customer_name" class="form-label">Tên</label>
            <input type="text" class="form-control" id="customer_name" placeholder="Nhập họ tên" name="customer_name">
        </div>

        <div class="col">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email">
        </div>
        <div class="col">
            <label for="is_active" class="form-label">Trạng thái</label>
            <select id="is_active" class="form-control" name="is_active">
                <option value="" selected>Chọn trạng thái</option>
                <option value="1">Hoạt động</option>
                <option value="0">Không hoạt động</option>
            </select>
        </div>
        <div class="col">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <a class="btn btn-primary" id="create" data-toggle="modal" data-target="#createForm"><i class="fa fa-user-plus"></i>Thêm mới</a>
            <a class="btn btn-success" id="ImportCSV"><i class="fa fa-upload"></i>Import CSV</a>
            <a class="btn btn-success" id="ExportCSV"><i class="fa fa-download"></i>Export CSV</a>
        </div>
        <!-- <div class="col">
            <a class="btn btn-primary" id="create_product" href="#"><i class="fa fa-user-plus"></i>Thêm mới</a>
        </div> -->
        <div class="col-3">
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-labeled btn-primary">
                        <i class="fa fa-search"></i>Tìm kiếm</button>
                </div>
                <div class="col-4 delete-search">
                    <a class="btn btn-success">
                        <i class="fa fa-times"></i>Xóa tìm</a>
                </div>
            </div>

        </div>
    </div>
</form>
@error('file')
<div class="alert alert-danger" role="alert">
    {{ $message }}
</div>
@enderror
@if(Session::has('fail-export'))
<div class="alert alert-danger" role="alert">
    {{Session::get('fail-export')}}
</div>
@endif
@if(Session::has('succesz'))
<div class="alert alert-success" role="alert">
    {{Session::get('success')}}
</div>
@endif
@if(Session::has('import-errors'))
@foreach(Session::get('import-errors') as $failure)

<div class="alert alert-danger" role="alert">
    {{$failure->errors()[0]}} ở dòng thứ {{$failure->row()}}
</div>
@endforeach
@endif
<div id="table_data">
    @include('Customer/customer-data')
</div>

<input id="hidden_page" value="1" type="hidden" name="hidden_page">
<!-- Modal Add Userr-->
<div class="modal fade" id="createForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="alert alert-danger" id="error_messege_create" style="display:none"></div>
            <div class="modal-header">
                <h5 class="modal-title">Thêm mới</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="formAddCustomer" style="padding:10px">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Tên</label>
                        <div class="col">
                            <input type="text" class="form-control" id="createName" name="name" placeholder="Nhập họ tên">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="createEmail" class="col-sm-3 col-form-label">Email</label>
                        <div class="col">
                            <input type="text" class="form-control" id="createEmail" name="email" placeholder="Nhập email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="createPhone" class="col-sm-3 col-form-label">Điện thoại</label>
                        <div class="col">
                            <input type="text" class="form-control" id="createPhone" name="phone" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="createAddress" class="col-sm-3 col-form-label">Địa chỉ</label>
                        <div class="col">
                            <input type="text" class="form-control" id="createAddress" name="address" placeholder="Nhập địa chỉ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="createIsActive" class="col-sm-3 col-form-label">Trạng thái</label>
                        <div class="col">
                            <input type="checkbox" class="form-check-input" id="createIsActive" name="is_active" value="1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col" style="display: flex;justify-content: flex-end;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger" style="margin-left:20px">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal Error Edit -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Thông báo lỗi</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="error_messege_edit" style="display:none"></div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Import  -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="alert alert-danger" id="error_messege_import" style="display:none"></div>
            <div class="modal-header">
                <h5 class="modal-title">Import CSV</h5>
            </div>
            <div class="modal-body">
                <form id="formImport" action="{{route('import-customer')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type='file' id="file" name="file" />

                    <button type="submit" class="btn btn-success">Import File</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section("js-content")
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        $('#editable').Tabledit({
            url: '{{route("edit-customer")}}',
            dataType: "json",
            columns: {
                identifier: [1, 'id'],
                editable: [
                    [2, 'name'],
                    [3, 'email'],
                    [4, 'address'],
                    [5, 'phone'],
                    [6, 'is_active', '{"1":"Hoạt động", "0":"Tạm khóa"}']
                ]
            },
            restoreButton: false,
            onSuccess: function(data, textStatus, jqXHR) {
                console.log(data.status);
                if (data.status == "success") {
                    console.log("thanh cong");
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
                    $('#errorModal').modal('show');

                    $('.alert-danger').html('');

                    $.each(data.message, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>' + value + '</li>');
                    });                   
                }

            }
        });
        $(document).on('click', '#create', function(event) {
            document.getElementById("error_messege_create").style.display = "none";
            $('#error_messege_create').html('');
        });
        $(document).on('click', '#ImportCSV', function(event) {
            document.getElementById("error_messege_import").style.display = "none";
            $('#error_messege_import').html('');
            $('#importModal').modal('show');
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            console.log(page);
            $("#hidden_page").val(page);
            var name = $('#customer_name').val();
            var email = $("#email").val();
            $select = document.querySelector('#is_active');
            var isActive = $select.value;
            var address = $("#address").val();

            fetchData(page, name, email, isActive, address);
        });
        $('#ExportCSV').on('click', function(event) {
            event.preventDefault();
            $select = document.querySelector('#is_active');
            var query = {
                name: $('#customer_name').val(),
                email: $("#email").val(),
                is_active: $select.value,
                address: $("#address").val(),
            }
            var url = "{{route('export-customer')}}?" + $.param(query);
            window.location = url;
        });
        $(document).on('click', '.delete-search a', function(event) {
            event.preventDefault();
            var page = 1
            $("#customer_name").val("");
            $("#email").val("");
            $("#address").val("");

            $select = document.querySelector('#is_active');
            $select.text = 'Chọn trạng thái';
            $select.value = '';
            fetchData(page, "", "", "", "");
        });
        $('#formSearchCustomer').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formSearchCustomer').serialize();
            var name = $('#customer_name').val();
            var email = $('#email').val();
            $select = document.querySelector('#is_active');
            var isActive = $select.value;

            var address = $('#address').val();

            var page = 1;
            fetchData(page, name, email, isActive, address);
        });

        $('#formAddCustomer').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formAddCustomer').serialize();
            addCustomer(formData);
        });
    });

    function fetchData(page, name, email, isActive, address) {
        $.ajax({
            url: "{{route('fetch-data-customer')}}" + "?page=" + page + "&name=" + name + "&email=" + email + "&is_active=" + isActive + "&address=" + address,
            success: function(data) {
                $('#table_data').html('');
                $('#table_data').html(data);
                $('#editable').Tabledit({
                    url: '{{route("edit-customer")}}',
                    dataType: "json",
                    columns: {
                        identifier: [1, 'id'],
                        editable: [
                            [2, 'name'],
                            [3, 'email'],
                            [4, 'address'],
                            [5, 'phone'],
                            [6, 'is_active', '{"1":"Hoạt động", "0":"Tạm khóa"}']
                        ]
                    },
                    restoreButton: false,
                    onSuccess: function(data, textStatus, jqXHR) {
                        console.log(data.status);
                        if (data.status == "success") {
                            console.log("thanh cong");
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
                            $('#errorModal').modal('show');

                            $('.alert-danger').html('');

                            $.each(data.message, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>' + value + '</li>');
                            });

                        }

                    }
                });
            }
        });
    }

    function addCustomer(formData, image) {
        $.ajax({
            type: "Post",
            url: "{{route('add-customer')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function(data) {
                if (data.status == "errors") {
                    $('.alert-danger').html('');

                    $.each(data.message, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>' + value + '</li>');
                    });
                } else {
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
                }
            }
        });
    }

    function importCustomer(formData) {
        $.ajax({
            type: "Post",
            url: "{{route('import-customer')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function(data) {

                if (data.status == "errors") {
                    $('.alert-danger').html('');

                    $.each(data.message, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>' + value + '</li>');
                    });
                } else {
                    console.log("Import thành công");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
</script>
@endsection