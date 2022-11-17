{{$listUser->links('pagination')}}
<table style="margin:10px;" class="table table-striped" id="table2">
    <thead>
        <tr class="table-danger" style="--bs-table-bg: red; color:white">
            <th scope="col">#</th>
            <th scope="col">Họ tên</th>
            <th scope="col">Email</th>
            <th scope="col">Nhóm</th>
            <th scope="col">Trạng thái</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody id="product_body">
        <?php $i = ($listUser->currentpage()-1)* $listUser->perpage() + 1;?>
        @forelse ($listUser as $user)
        <tr>
            <th scope="row"><span>{{$i++}}</span></th>
            <td><span id="user_name">{{ $user->name}}</span></td>
            <td><span id="user_email">{{ $user->email}}</span></td>
            <td><span id="user_group_role">{{ $user->group_role}}</span></td>
            <td class="{{$user->is_active==1?'text-success':'text-danger'}}"><span id="user_active">{{ $user->is_active==1?'Hoạt động':"Tạm khóa"}}</span></td>
            <td>
                <a id="edit" data-toggle="modal" data-target="#editForm" data-url="{{ route('edit-user').'&id='.$user->id}}"><i class="fas fa-pencil-alt"></i></a>
                <!-- <a id="edit_popup"><i class="fas fa-pencil-alt"></i></a> -->
                <a class="_delete_user" id="{{$user->id}}" data-url="{{ route('delete-user', $user->id).'&name='.$user->name }}"><i class="fa fa-trash" style="color:red"></i></a>
                <a class="_lock_user" id="{{$user->id}}" data-url="{{ route('lock-user', $user->id).'&name='.$user->name.'&is_active='.$user->is_active }}"><i class="fa fa-user-times" style="color:black"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>