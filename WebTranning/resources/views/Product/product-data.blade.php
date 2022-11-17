{{$listProduct->links('pagination')}}
<!-- Bang du lieu -->
<table style="margin:10px;" class="table table-striped" id="table2">
    <thead>
        <tr class="table-danger" style="--bs-table-bg: red; color:white">
            <th scope="col">#</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Mô tả</th>
            <th scope="col">Giá</th>
            <th scope="col">Tình trạng</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody id="product_body">
        <?php $i = ($listProduct->currentpage() - 1) * $listProduct->perpage() + 1; ?>
        @forelse ($listProduct as $product)
        <tr>
            <th scope="row">{{$i++}}</th>
            <td>
                <div class="hover_container">
                    <div class="text">{{ $product->product_name}}</div>
                    <div class="image">
                        <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/8/8a/Banana-Single.jpg" alt="" /> -->

                        <img src="{{!$product->product_image ? asset('assets/dist/img/default-150x150.png') : asset('storage/'.$product->product_image) }}" alt="" width="200" height="200" />
                    </div>
                </div>
                <!-- <a class="trigger" style="text-decoration: none">{{ $product->product_name}}</a>
                <div id="pop_up">
                    <img src="{{ $product->product_image}}" alt="{{ $product->product_name}}" width="500" height="600">
                </div> -->
            </td>
            <td>{!!strlen($product->description)>50? substr($product->description,0,50).'...':$product->description !!}</td>
            <td class="text-success">${{ $product->product_price}}</td>
            <td class="{{$product->is_sales==1?'text-success':'text-danger'}}">{{ $product->is_sales==1?'Đang bán':"Ngừng hàng"}}</td>
            <td>
                <a href="{{route('edit-product',['id'=>$product->product_id])}}"><i class="fas fa-pencil-alt"></i></a>
                <a class="_delete_data" id="{{$product->product_id}}" data-url="{{ route('delete-product', $product->product_id).'&name='.$product->product_name }}"><i class="fa fa-trash" style="color:red"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Không có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>