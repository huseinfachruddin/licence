<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser(Request $request){
        $data = User::with('roles')->paginate(10);
        $response = [
            'success'   => true,
            'user'      => $data,
        ];
    
        return response($response,200);
    }

    public function detailUser(Request $request){
        $data = User::with('roles')->where('id',$request->id)->first();
        $response = [
            'success'   => true,
            'user'      => $data,
        ];
        return response($response,200);
    }
    public function editUser(Request $request){
        $data = User::find($request->id);
        $request->validate([
            'name'  =>'required|unique:users,name,'.$data->id,
            'email' =>'required|email|unique:users,email,'.$data->id,
            'phone' =>'nullable',
        ]);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
            if (!empty($request->role)) {
                $data->roles()->detach();
                if (is_array($request->role)) {
                    foreach ($request->role as $key => $value) {
                        $user = User::where('id',$request->id)->first();
                        $user = $user->syncRoles($request->role);
                    }
                }else{
                    $user = User::where('id',$request->id)->first();
                    $user = $user->syncRoles($request->role);
                }
            }
        $data->save();
        $response = [
            'success'   => true,
            'user'      => $data,
        ];
        return response($response,200);
    }

    public function deleteUser(Request $request){
        $data = User::find($request->id);
        
        $data->delete();
        $response = [
            'success'   => true,
            'user'      => $data,
        ];
        return response($response,200);
    }
}
