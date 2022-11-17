@extends("layout/layout")
@section("name-page")
<title>Product</title>
@endsection
@section("name-content")
<h3>Chi tiết sản phẩm</h3>
@endsection
@section("main-content")
<form style="margin:30px;" method="Post" action="{{route('edit-product',['id'=>$product->product_id])}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col">
            <div class="form-group row">
                <label for="product_name" class="col-sm-2 col-form-label">Tên sản phẩm</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nhập tên sản phẩm" value="{{$product->product_name}}">
                    @error('product_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="product_price" class="col-sm-2 col-form-label">Giá bán</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Nhập giá bán" value="{{$product->product_price}}">
                    @error('product_price')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="product_description" class="col-sm-2 col-form-label">Mô tả</label>
                <div class="col-sm-6">
                    <textarea class="ckeditor form-control" name="product_description" id="product_description" placeholder="Mô tả sản phẩm" rows="7">{!!$product->description !!}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="is_sales" class="col-sm-2 col-form-label">Trạng thái</label>
                <div class="col-sm-6">
                    <select id="is_sales" class="form-control" name="is_sales">
                        <option hidden disabled>Chọn trạng thái</option>
                        <option value="1" {{$product->is_sales==1?"selected":""}}>Đang bán </option>
                        <option value="0" {{$product->is_sales==0?"selected":""}}>Ngừng bán </option>
                    </select>
                    @error('is_sales')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col">
            <label for="photo" class="col-sm-2 col-form-label">Hình ảnh</label>
            <br>
            <div class="form-group row" style="margin-right: 300px;">
                <!-- <img id="photo" src="{{asset('assets/dist/img/default.png')}}" width="500" height="200"> -->
                <img id="photo" src="{{!$product->product_image ? asset('assets/dist/img/default.png') : asset('storage/'.$product->product_image) }}" width="500" height="200">
            </div>
            <br>
            <input type='file' id="upload" name="product_image" class="file" accept="image/*" onchange="document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])" />
            <br>
            <button onclick="resetFile()">Reset file</button>
            @error('product_image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col" style="margin-left: 900px;">
            <a class="btn btn-secondary" href="{{route('list-product')}}">Hủy</a>
            <button type="submit" class="btn btn-labeled btn-danger">Lưu</button>
        </div>
    </div>
    </div>
</form>
@endsection

@section("js-content")
<script>
    $(document).ready(function() {});

    function resetFile() {
        event.preventDefault();
        const file = document.querySelector('.file');
        file.value = '';
        const photo = document.getElementById('photo');
        photo.src = "{{asset('assets/dist/img/default.png')}}";
    }
</script>
@endsection