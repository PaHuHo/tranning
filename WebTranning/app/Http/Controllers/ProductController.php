<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\MstProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class ProductController extends Controller
{
    public function index()
    {
        //$listProduct=MstProduct::all();
        $listProduct = MstProduct::orderBy('updated_at','desc')->paginate(20);
        return View('Product/home', ['listProduct' => $listProduct]);
    }
    public function fetchData(Request $request)
    {
        //dd($request->all());
        //dd($request->is_sales);
        //$listProduct=MstProduct::all();
        if ($request->ajax()) {
            // $listProduct = MstProduct::orderBy('created_at','desc')->paginate(25);
            $listProduct = MstProduct::Where(function ($q) use ($request) {
                $q->when($request->filled('product_name'), function ($q) use ($request) {
                    $q->where('product_name', 'LIKE', '%' . $request->product_name . '%');
                })
                    ->when($request->filled('is_sales'), function ($q) use ($request) {
                        $q->where('is_sales', $request->is_sales);
                    })
                    ->when($request->filled('price_min', 'price_max'), function ($q) use ($request) {
                        $q->whereBetween('product_price', [(int)$request->price_min, (int)$request->price_max]);
                    });
            })->orderBy('updated_at','desc')->paginate(20)->appends($request->except(['page', '_token']));
            return View('Product/product-data', ['listProduct' => $listProduct])->render();
        }
    }
    public function searchProduct(Request $request)
    {
        //dd($request->except(['page','_token']));
        if ($request->ajax()) {
            $listProduct = MstProduct::Where(function ($q) use ($request) {
                $q->when($request->filled('product_name'), function ($q) use ($request) {
                    $q->where('product_name', 'LIKE', '%' . $request->product_name . '%');
                })
                    ->when($request->filled('is_sales'), function ($q) use ($request) {
                        $q->where('is_sales', $request->is_sales);
                    })
                    ->when($request->filled('price_min', 'price_max'), function ($q) use ($request) {
                        $q->whereBetween('product_price', [(int)$request->price_min, (int)$request->price_max]);
                    });
            })->orderBy('created_at','desc')->paginate(20)->appends($request->except(['page', '_token']));
            return View('Product/product-data', ['listProduct' => $listProduct])->render();
        }
    }

    public function addProduct()
    {
        //$listProduct=MstProduct::all();
        return View('Product/add-product');
    }
    public function storeAddProduct(ProductRequest $request)
    {   
        $first = strtoupper(substr($request->product_name, 0, 1));
        $count = MstProduct::where('product_id', 'LIKE', $first . '%')->count();
        $product = new MstProduct();
        $product->product_id = $first . substr("000000000", strlen($count + 1)) . ($count + 1);
        $product->product_name = $request->product_name;
        $product->product_image = $request->product_image;
        $product->product_price = $request->product_price;
        $product->description = $request->product_description;
        $product->is_sales = $request->is_sales;
        if($request->hasFile('product_image')){
            $image=$request->product_image;
            $fileName=$product->product_id.".".$request->file('product_image')->extension();
            $resized_img = Image::make($image)->resize(512, 512)->stream();
            Storage::disk('public')->put('profile/' . $fileName,$resized_img);
            $product->product_image="profile/".$fileName;
        }
        $product->save();
        return redirect()->route('list-product');
    }
    public function editProduct($id)
    {
        $product = MstProduct::where('product_id', $id)->first();
        //$product=MstProduct::find($id);
        return View('Product/edit-product', ['product' => $product]);
    }
    public function storeEditProduct(ProductRequest $request, $id)
    {
        //dd($request->hasFile('product_image'));
        $product=MstProduct::where('product_id', $id)->first();
        if($request->hasFile('product_image')){
            $image=$request->product_image;
            $fileName=$product->product_id.".".$request->file('product_image')->extension();
            $resized_img = Image::make($image)->resize(512, 512)->stream();
            Storage::disk('public')->put('profile/' . $fileName,$resized_img);
            if (file_exists(public_path() . '/storage/' . $product->product_image)) {
                @unlink(public_path() . '/storage/' . $product->product_image, );
            }
            $product_image="profile/".$fileName;
        }else{
            $product_image=$product->product_image;
        }
        
        $product=MstProduct::where('product_id', $id)->update(array(
            'product_name' => $request->product_name,
            'product_image' => $product_image,
            'product_price' => $request->product_price,
            'description' => $request->product_description,
            'is_sales' => $request->is_sales,
        ));
        return redirect()->route('list-product');
    }

    public function deleteProduct($id)
    {
        $product = MstProduct::where('product_id', $id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ], 200);
        // $listProduct = MstProduct::paginate(20);
        // return View('Product/home', ['listProduct' => $listProduct])->render();
    }
}
