{{$listCustomer->links('pagination')}}
<!-- id="editable" -->
<table style="margin:10px;" class="table table-striped" id="editable">
    <thead>
        <tr class="table-danger" style="--bs-table-bg: red; color:white">
            <th scope="col">#</th>
            <th scope="col">Họ tên</th>
            <th scope="col">Email</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Điện thoại</th>
            <th scope="col">Trạng thái</th>
        </tr>
    </thead>
    <tbody id="product_body">
        <?php $i = ($listCustomer->currentpage() - 1) * $listCustomer->perpage() + 1; ?>
        @forelse ($listCustomer as $customer)
        <tr >
            <th scope="row"><span>{{$i++}}</span></th>
            <td hidden>{{ $customer->customer_id}}</td>
            <td>{{ $customer->customer_name}}
                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
            </td>
            <td>{{ $customer->email}}</td>
            <td>{{ $customer->address}}</td>
            <td>{{ $customer->tel_num}}</td>
            <td class="{{$customer->is_active==1?'text-success':'text-danger'}}"><span id="user_active">{{ $customer->is_active==1?'Hoạt động':"Tạm khóa"}}</span></td>
            <!-- <td>
                <a id="editCustomer" data-url="{{ route('edit-user').'&id='.$customer->customer_id}}"><i class="fas fa-pencil-alt"></i></a>
            </td> -->
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>