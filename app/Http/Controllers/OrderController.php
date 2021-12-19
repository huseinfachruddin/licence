<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\Suborder;
use App\Models\Subcart;

class OrderController extends Controller
{
    public function getOrder(Request $request){
        $user = User::find($request->user()->id);
        if ($user->hasRole('admin')) {
            $data = Order::withTrashed()->with('user','suborder.package.product')->get();
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
        $data = Order::withTrashed()->with('user','suborder.package.product',)->where('id',$request->id)->first();

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
        dd($data);
        $data->status = $request->status;
        $data->save();

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
