<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licence;
use App\Models\Product;
use Illuminate\Support\Str;

class LicenceController extends Controller
{
    public function checkLicence(Request $request){
        $request->validate([
            'product_code'  =>'required',
            'licence'  =>'required',
        ]);
        $code=$request->product_code;
        $licence=$request->licence;
        $dns=$request->server('HTTP_ORIGIN');

        $product=Product::where('code',$code)->first();
        if (empty($product)) {
            $response = [
                'success'   => false,
                'errors' => ['check'=> 'product tidak ditemukan']
            ];
            return response($response,422);
        }
        $data =Licence::with('product','user')->where('licence',$licence)->where('product_id',$product->id)->first();

        if (empty($data) && $data->dns != $dns) {
            $response = [
                'success'   => false,
                'errors' => ['check'=> 'licence tidak ditemukan']
            ];
            return response($response,401);
        }else{
            if (empty($data->dns)) {
                $data = Licence::find($data->id);
                $data->dns=$dns;
                $data->save();
            }else{
                    $data = Licence::find($data->id);
                    $data->dns=$dns;
                    $data->save();
                
            }
        }

        $response = [
            'success'   => true,
            'licence'   => $data,
            'host'   => $dns,
        ];
        return response($response,200);
    }

    public function getLicence(Request $request){
        $data = Licence::with('product','user')->paginate(10);

        $response = [
            'success'   => true,
            'licence'   => $data,
        ];
        return response($response,200);
    }

    public function detailLicence(Request $request){
        $data = Licence::where('id',$request->id)->with('product','user')->first();

        $response = [
            'success'   => true,
            'licence'      => $data,
        ];
        return response($response,200);
    }

    public function createLicence(Request $request){
        $request->validate([
            'product_id'  =>'required',
            'user_id'  =>'required',
            'due'  =>'nullable',

        ]);

        $data = new Licence;
        $data->product_id = $request->product_id;
        $data->user_id = $request->user_id;
        $data->licence = Str::random(15);
        $data->due = date('Y-m-d',strtotime($request->due));
        $data->save();

        $response = [
            'success'   => true,
            'licence'      => $data,
        ];
        return response($response,200);
    }

    public function editLicence(Request $request){
        $request->validate([
            'product_id'  =>'required',
            'user_id'  =>'required',
            'dns'  =>'nullable',
            'due'  =>'nullable',
        ]);

        $data = Licence::find($request->id);
        $data->product_id = $request->product_id;
        $data->user_id = $request->user_id;
        $data->dns = $request->dns;
        $data->due = date('Y-m-d',strtotime($request->due));
        $data->save();

        $response = [
            'success'   => true,
            'licence'   => $data,
        ];
        return response($response,200);
    }

    public function deleteLicence(Request $request){

        $data = Licence::find($request->id);
        $data->delete();

        $response = [
            'success'   => true,
            'licence'   => $data,
        ];
        return response($response,200);
    }
}
