<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licence;
use App\Models\Product;
use App\Models\Domain;
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
                'errors' => ['check'=> 'produk tidak ditemukan']
            ];
            return response($response,422);
        }
        $data =Licence::with('product','user','domain')->where('licence',$licence)->where('product_id',$product->id)->where('due','<=',date('Y-m-d',time()))->first();

        if (empty($data)) {
            $response = [
                'success'   => false,
                'errors' => ['check'=> 'Ada kesalahan dalam lisensi']
            ];
            return response($response,401);
        }else{
                $domain = Domain::where('licence_id',$data->id)->where('domain',$dns)->first();
                if (empty($domain) || $domain->count() > $data->max_domain) {
                    $response = [
                        'success'   => false,
                        'errors' => ['check'=> 'domain belum terdaftar']
                    ];

                    return response($response,401);
                }
        }
        
        $response = [
            'success'   => true,
            'licence'   => $data,
        ];
        return response($response,200);
    }

    public function setLicence(Request $request){

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
            return response($response,401);
        }
        $data =Licence::with('product','user','domain')->where('licence',$licence)->where('product_id',$product->id)->first();

        if (empty($data) &&$data->due>date('Y-m-d',time())) {
            $response = [
                'success'   => false,
                'errors' => ['check'=> 'Ada masalah dalam lisensi']
            ];
            return response($response,401);
        }else{
            $domain = Domain::where('licence_id',$data->id)->where('domain',$dns)->first();

                if (!empty($domain) || $data->domain()->count() > $data->max_domain) {
                    $response = [
                        'success'   => false,
                        'errors' => ['check'=> 'Domain sudah terdaftar atau domain sudah penuh']
                    ];

                    return response($response,401);
                }else{
                    $domain = new Domain;
                    $domain->licence_id = $data->id;
                    $domain->domain = $dns;
                    dd($domain);
                    $domain->seve();
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
        $data = Licence::with('product','user','domain')->paginate(10);

        $response = [
            'success'   => true,
            'licence'   => $data,
        ];
        return response($response,200);
    }

    public function detailLicence(Request $request){
        $data = Licence::where('id',$request->id)->with('product','user','domain')->first();

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
            'max_domain'  =>'required',
            'due'  =>'nullable',

        ]);

        $data = new Licence;
        $data->product_id = $request->product_id;
        $data->user_id = $request->user_id;
        $data->licence = Str::random(15);
        $data->max_domain = $request->max_domain;
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
            'max_domain'  =>'required',
            'due'  =>'nullable',
        ]);

        $data = Licence::find($request->id);
        $data->product_id = $request->product_id;
        $data->user_id = $request->user_id;
        $data->max_domain = $request->max_domain;
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
