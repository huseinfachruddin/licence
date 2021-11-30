<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;

class DomainController extends Controller
{
    public function deleteDomain(Request $request){
        if (!empty($request->licence_id)) {
            $data = Domain::where($request->licence_id);
        }else{
            $data = Domain::find($request->id);
        }
        $data->delete();
        $response = [
            'success'   => true,
            'domain'      => $data,
        ];
        return response($response,200);
    }
}
