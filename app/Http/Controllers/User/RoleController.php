<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function getRole(Request $request){
        $data = Role::all();
        $response = [
            'success'   => true,
            'role'      => $data,
        ];
    
        return response($response,200);
    }

    public function detailRole(Request $request){
        $data = Role::where('id',$request->id)->first();
        $response = [
            'success'   => true,
            'role'      => $data,
        ];
        return response($response,200);
    }

    public function createRole(Request $request){
        $request->validate([
            'name'  =>'required|unique:roles,name,',
        ]);
        $data = new Role;
        $data->name = $request->name;
        $data->save();
        
        $response = [
            'success'   => true,
            'role'      => $data,
        ];
        return response($response,200);
    }

    public function editRole(Request $request){
        $data = Role::find($request->id);
        $request->validate([
            'name'  =>'required|unique:roles,name,'.$data->id,
        ]);
            if ($data->name=='admin') {
                $response = [
                    'success'   => false,
                    'errors' => ['role'=> 'role admin tidak bisa diubah']
                ];
                return response($response,422);
            }
        $data->name = $request->name;
        $data->save();

        $response = [
            'success'   => true,
            'role'      => $data,
        ];
        return response($response,200);
    }

    public function deleteRole(Request $request){
        $data = Role::find($request->id);
            if ($data->name=='admin') {
                $response = [
                    'success'   => false,
                    'errors' => ['role'=> 'role admin tidak bisa dihapus']
                ];
                return response($response,422);
            }
        $data->delete();
        $response = [
            'success'   => true,
            'role'      => $data,
        ];
        return response($response,200);
    }
}
