<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProduct(Request $request){
        if ($request->all==true) {
            $data = Product::all();
        }else{
            $data = Product::paginate(10);
        }
        $response = [
            'success'   => true,
            'product'      => $data,
        ];
    
        return response($response,200);
    }

    public function detailProduct(Request $request){
        $data = Product::with('package')->where('id',$request->id)->first();
        $response = [
            'success'   => true,
            'product'      => $data,
        ];
        return response($response,200);
    }

    public function createProduct(Request $request){
        $request->validate([
            'code'  =>'required|unique:products,code',
            'name'  =>'required',
            'desc'  =>'nullable',

        ]);
        $data = new Product;
        $data->code = $request->code;
        $data->name = $request->name;
        $data->desc = $request->desc;
        $data->save();
        
        $response = [
            'success'   => true,
            'product'      => $data,
        ];
        return response($response,200);
    }

    public function editProduct(Request $request){
        $data = Product::find($request->id);
        $request->validate([
            'code'  =>'required|unique:products,code,'.$data->id,
            'name'  =>'required',
            'desc'  =>'nullable',
        ]);
        
        $data = Product::find($request->id);
        $data->code = $request->code;
        $data->name = $request->name;
        $data->desc = $request->desc;
        $data->save();

        $response = [
            'success'   => true,
            'product'      => $data,
        ];
        return response($response,200);
    }

    public function deleteProduct(Request $request){
        $data = Product::find($request->id);
        $data->delete();
        $response = [
            'success'   => true,
            'product'      => $data,
        ];
        return response($response,200);
    }
}
