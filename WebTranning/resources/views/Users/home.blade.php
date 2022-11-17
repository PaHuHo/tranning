@extends("layout/layout")
@section("name-page")
<title>User</title>
@endsection

@section("name-content")
<h3>Users</h3>
@endsection

@section("main-content")
<form style="margin:10px;" id="formSearchUser" method="get" action="">
    @csrf
    <div class="row">
        <div class="col">
            <label for="name" class="form-label">Tên</label>
            <input type="text" class="form-control" id="name" placeholder="Nhập họ tên" name="product_name">
        </div>

        <div class="col">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email">
        </div>
        <div class="col">
            <label for="group_role" class="form-label">Nhóm</label>
            <select id="group_role" class="form-control" name="group_role">
                <option value="" selected>Chọn nhóm</option>
                <option value="Admin">Admin</option>
                <option value="Reviewer">Reviewer</option>
                <option value="Editor">Editor</option>
            </select>
        </div>
        <div class="col">
            <label for="is_active" class="form-label">Trạng thái</label>
            <select id="is_active" class="form-control" name="is_active">
                <option value="" selected>Chọn trạng thái</option>
                <option value="0">Không hoạt động</option>
                <option value="1">Hoạt động</option>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <a class="btn btn-primary" id="create" data-toggle="modal" data-target="#createForm"><i class="fa fa-user-plus"></i>Thêm mới</a>
        </div>
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

<div id="table_data">
    @include('Users/user-data')
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

                <form method="POST" action="{{route('add-user')}}" id="formAddUser" style="padding:10px">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Tên</label>
                        <div class="col">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ tên">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Mật khẩu</label>
                        <div class="col">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Xác nhận</label>
                        <div class="col">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập xác nhận mật khẩu">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="group_role" class="col-sm-2 col-form-label">Nhóm</label>
                        <div class="col">
                            <select id="group_role" class="form-control" name="group_role">
                                <option hidden disabled>Chọn nhóm</option>
                                <option value="Admin">Admin</option>
                                <option value="Reviewer">Reviewer </option>
                                <option value="Editor">Editor</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="is_active" class="col-sm-2 col-form-label">Trạng thái</label>
                        <div class="col">
                            <input type="checkbox" class="form-check-input" name="is_active" value="1">
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

<!-- Modal Edit Userr-->
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="alert alert-danger" id="error_messege_edit" style="display:none"></div>
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="formEditUser" style="padding:10px">
                    @csrf
                    <input hidden type="text" class="form-control" id="editID" name="id" readonly>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Tên</label>
                        <div class="col">
                            <input type="text" class="form-control" id="editName" name="name" placeholder="Nhập họ tên">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col">
                            <input type="text" class="form-control" id="editEmail" name="email" placeholder="Nhập email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Mật khẩu</label>
                        <div class="col">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Xác nhận</label>
                        <div class="col">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập xác nhận mật khẩu">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="group_role" class="col-sm-2 col-form-label">Nhóm</label>
                        <div class="col">
                            <select id="editGroupRole" class="form-control" name="group_role">
                                <option hidden disabled>Chọn nhóm</option>
                                <option value="Admin">Admin</option>
                                <option value="Reviewer">Reviewer </option>
                                <option value="Editor">Editor</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="is_active" class="col-sm-2 col-form-label">Trạng thái</label>
                        <div class="col">
                            <input type="checkbox" class="form-check-input" id="editIsActive" name="is_active" value="1">
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
@endsection

@section("js-content")
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $(document).on('click', '#create', function(event) {
            document.getElementById("error_messege_create").style.display = "none";
            $('#error_messege_create').html('');
        });
        $(document).on('click', '#edit', function(event) {
            document.getElementById("error_messege_edit").style.display = "none";
            $('#error_messege_edit').html('');

            var id = $(this).data('url').split('&id=')[1];

            var name = $(this).closest('tr').find('#user_name').text();
            var email = $(this).closest('tr').find('#user_email').text();
            var groupRole = $(this).closest('tr').find('#user_group_role').text();
            var active = $(this).closest('tr').find('#user_active').text();

            console.log(id);

            $('#editID').val(id);
            $('#editName').val(name);
            $('#editEmail').val(email);

            $select = document.querySelector('#editGroupRole');
            $select.text = groupRole;
            $select.value = groupRole;

            $('#editIsActive').prop("checked", active == "Hoạt động" ? true : false);
        })


        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $("#hidden_page").val(page);
            var name = $('#name').val();
            var email = $("#email").val();
            $select = document.querySelector('#group_role');
            var groupRole = $select.value;
            $select = document.querySelector('#is_active');
            var isActive = $select.value;

            fetchData(page, name, email, groupRole, isActive);
        });
        $(document).on('click', '.delete-search a', function(event) {
            event.preventDefault();
            var page = 1
            $("#name").val("");
            $("#email").val("");
            $select = document.querySelector('#group_role');
            $select.text = 'Chọn nhóm';
            $select.value = '';

            $select = document.querySelector('#is_active');
            $select.text = 'Chọn trạng thái';
            $select.value = '';
            fetchData(page, "", "", "", "");
        });
        $('#formSearchUser').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formSearchUser').serialize();
            var name = $('#name').val();
            var email = $('#email').val();
            $select = document.querySelector('#group_role');
            var groupRole = $select.value;
            $select = document.querySelector('#is_active');
            var isActive = $select.value;
            var page = 1;
            fetchData(page, name, email, groupRole, isActive);
        });

        $('#formAddUser').on('submit', function(event) {
            event.preventDefault();
            var formData = $('#formAddUser').serialize();
            addUser(formData);
        });
        $('#formEditUser').on('submit', function(event) {
            event.preventDefault();
            var id = $('#Id').val();
            var formData = $('#formEditUser').serialize();
            editUser(formData, id);
        });
        $(document).on('click', '._delete_user', function() {
            var id = $(this).data("id");
            var url = $(this).data('url').split('&name=')[0];
            var name = $(this).data('url').split('name=')[1];
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "Nhắc nhở",
                text: "Bạn có chắc muốn xóa thành viên " + name.toUpperCase() + " không",
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

        $(document).on('click', '._lock_user', function() {
            var id = $(this).data("id");
            var url = $(this).data('url').split('&name=')[0];
            var name = $(this).data('url').split('&is_active=')[0].split('name=')[1];
            console.log(name);
            var str = $(this).data('url').split('is_active=')[1] == 1 ? "khóa" : "mở khóa";
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "Nhắc nhở",
                text: "Bạn có muốn " + str + " thành viên " + name.toUpperCase() + " không",
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
                                swal("Lock!", data.message, "error");
                            }
                        }
                    });
                }
            });
        });

    });

    function fetchData(page, name, email, groupRole, isActive) {
        $.ajax({
            url: "{{route('fetch-data-user')}}" + "?page=" + page + "&name=" + name + "&email=" + email + "&group_role=" + groupRole + "&is_active=" + isActive,
            success: function(data) {
                $('#table_data').html('');
                $('#table_data').html(data);
            }
        });
    }

    function addUser(formData) {
        $.ajax({
            type: "Post",
            url: "{{route('add-user')}}",
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

    function editUser(formData, idUser) {
        $.ajax({
            type: "Post",
            url: "{{route('edit-user')}}",
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
</script>
@endsection