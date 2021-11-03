<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

class Auth extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'  =>'required|unique:users,name',
            'email' =>'required|email|unique:users,email',
            'phone' =>'required',
            'password'  =>'required|min:6',
            'rePassword'  =>'required|min:6|same:password',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        $response = [
            'success'=>true,
            'user'  =>$user,
        ];

        return response($response,200);
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user= User::where('name', $request->name)->first();
        
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'success'   => false,
                    'errors' => ['auth'=> 'Incorrect username and password']
                ], 404);
            }
        
            $token = $user->createToken('ApiToken')->plainTextToken;
        
            $response = [
                'success'   => true,
                'user'      => $user,
                'token'     => $token
            ];
        
        return response($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'success'=>true,
            'message'=>'Anda berhasil di logout',
        ];
        return response($response,200);
    }
}
