<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class UserController extends Controller
{
    public function register(Request $request){
        // $validator = $this->validate($request, [
        //     'username' =>'required|unique:users,username',
        //     'email' => 'required|unique:users|email',
        //     'password' => 'required|min:6'
        // ]);
        $validator = Validator::make($request->all(), [
            'username' =>'required|unique:users,username',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors() , 200);
        }

        $username = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $generateToken = bin2hex(random_bytes(40));
        $user = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'token' => $generateToken
        ]);

        return response()->json([
            'message' => 'Pendaftaran pengguna berhasil dilaksanakan' ,
            'id' => $user->id,
            'token' => $user->token
        ]);
    }

    public function show($id){

    }
}
