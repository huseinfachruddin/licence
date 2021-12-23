<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    public function getPackage(Request $request){
        $data = Package::where('product_id',$request->product_id)->orderBy('id', 'DESC')->get();
        $response = [
            'success'   => true,
            'package'     => $data,
        ];
    
        return response($response,200);
    }

    public function detailPackage(Request $request){
        $data = Package::where('id',$request->id)->first();
        $response = [
            'success'   => true,
            'package'     => $data,
        ];
        return response($response,200);
    }

    public function createPackage(Request $request){
        $request->validate([
            'product_id'  =>'required',
            'name'  =>'required',
            'desc'  =>'nullable',
            'num_licence'  =>'nullable',
            'num_domain'  =>'nullable',
            'num_expired'  =>'nullable',
            'price'  =>'required',
        ]);
        $data = new Package;
        $data->product_id = $request->product_id;
        $data->name = $request->name;
        $data->desc = $request->desc;
        $data->num_licence = $request->num_licence;
        $data->num_domain = $request->num_domain;
        $data->num_expired = $request->num_expired;
        $data->price = $request->price;
        $data->save();
        
        $response = [
            'success'   => true,
            'package'     => $data,
        ];
        return response($response,200);
    }

    public function editPackage(Request $request){
        $data = Package::find($request->id);
        $request->validate([
            'product_id'  =>'required',
            'name'  =>'required',
            'desc'  =>'nullable',
            'num_licence'  =>'nullable',
            'num_domain'  =>'nullable',
            'num_expired'  =>'nullable',
            'price'  =>'required',
        ]);
        
        $data = Package::find($request->id);
        $data->product_id = $request->product_id;
        $data->name = $request->name;
        $data->desc = $request->desc;
        $data->num_licence = $request->num_licence;
        $data->num_domain = $request->num_domain;
        $data->num_expired = $request->num_expired;
        $data->price = $request->price;
        $data->save();

        $response = [
            'success'   => true,
            'package'     => $data,
        ];
        return response($response,200);
    }

    public function deletePackage(Request $request){
        $data = Package::find($request->id);
        $data->delete();
        $response = [
            'success'   => true,
            'package'      => $data,
        ];
        return response($response,200);
    }
}
