<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Subcart;
use App\Models\Package;

class CartController extends Controller
{
    public function getCart(Request $request){
        $data = Cart::with('subcart.package.product','user')->where('user_id',$request->user()->id)->orderBy('id', 'DESC')->first();

        $response = [
            'success'   => true,
            'cart'     => $data,
        ];
    
        return response($response,200);
    }

    public function createCart(Request $request){
        $request->validate([
            'package_id'  =>'required',
        ]);

        $data = Cart::where('user_id',$request->user()->id)->first();
        if ($data) {
            $sub = Subcart::where('cart_id',$data->id)->where('package_id',$request->package_id)->first();
            if ($sub) {
                $sub = Subcart::find($sub->id);
                $sub->amount = 1; 
                $sub->save(); 
            }else{
                $sub = new Subcart;
                $sub->cart_id = $data->id;
                $sub->package_id = $request->package_id; 
                $sub->amount = 1;
                $sub->save();
            }
        }else{
            $data = new Cart;
            $data->user_id = $request->user()->id;
            $data->save();

            $sub = new Subcart;
            $sub->cart_id = $data->id; 
            $sub->package_id = $request->package_id; 
            $sub->amount = 1;
            $sub->save();

            $package = Package::find($sub->package_id);

            $sub = Subcart::find($sub->id);
            $sub->total = $package->price * $sub->amount;
            $sub->save();
        }

        $sub = Subcart::find($sub->id);
        $package =Package::find($sub->package_id);
        $sub->total = $package->price * $sub->amount;
        $sub->save();

        $response = [
            'success'   => true,
            'cart'     => $sub->total,
        ];
        return response($response,200);
    }

    public function deleteSubcart(Request $request){
        $data = Subcart::find($request->id);
        $data->delete();
        
        $response = [
            'success'   => true,
            'cart'     => $data,
        ];
    
        return response($response,200);
    }
}
