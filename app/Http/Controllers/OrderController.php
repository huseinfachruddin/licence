<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\Suborder;
use App\Models\Subcart;
use App\Models\Licence;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function getOrder(Request $request){
        $user = User::find($request->user()->id);
        if ($user->hasRole('admin')) {
            $data = Order::with('user','suborder.package.product')->get();
        }else{
            $data = Order::with('user','suborder.package.product')->where('user_id',$request->user()->id)->get();
        }

        $response = [
            'success'   => true,
            'order'      => $data,
        ];
        return response($response,200); 
    }

    public function detailOrder(Request $request){
        $data = Order::with('user','suborder.package.product',)->where('id',$request->id)->first();

        $response = [
            'success'   => true,
            'order'      => $data,
        ];
        return response($response,200); 
    }

    public function createOrder(Request $request){
        $cart = Cart::find($request->id);

        $data = new Order;
        $data->user_id = $request->user()->id;
        $data->save();

        $total = 0;
        $sub = Subcart::where('cart_id',$cart->id)->get();
        foreach ( $sub as $key => $value) {
            $sub = new Suborder;
            $sub->order_id = $data->id;
            $sub->package_id = $value->package_id;
            $sub->amount = $value->amount;
            $sub->total = $value->total;
            $sub->save();
            $total += $sub->total;
        }
        
        $data = Order::find($data->id);
        $data->total = $total;
        $data->save();
        $cart->delete();
        $response = [
            'success'   => true,
            'order'      => $data,
        ];
        return response($response,200); 
    }

    public function editOrder(Request $request){
        $request->validate([
            'status'  =>'required',
        ]);
        
        $data = Order::find($request->id);
        $data->status = $request->status;
        if ($request->method) $data->method = $request->method;
        if ($request->total) $data->total = $request->total;
        $data->save();
        if ($data->status=='sudah dibayar') {
            $order = Order::with('user','suborder.package.product')->where('id',$request->id)->first();
            foreach ($order->suborder as $key => $value) {
                $product = $value->package->product;
                for ($i=0; $i < $value->package->num_licence; $i++) { 
                    $data = new Licence;
                    $data->product_id = $product->id;
                    $data->user_id = $order->user->id;
                    $data->licence = Str::random(15);
                    $data->max_domain = $value->package->num_domain;
                    $data->due = date('Y-m-d',strtotime("+".$value->package->num_expired." days"));
                    $data->save();
                }
            }
        }

        $response = [
            'success'   => true,
            'order'      => $data,
        ];
        return response($response,200); 
    }


    public function deleteOrder(Request $request){
        $data = Order::find($request->id);
        $data->delete();

        $response = [
            'success'   => true,
            'order'      => $data,
        ];
        return response($response,200); 
    }
}
