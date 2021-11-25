<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'username' =>'required|unique:users,username',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6'
        ]);
        $username = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $user = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);

        return response()->json(['message' => 'Pendaftaran pengguna berhasil dilaksanakan']);
    }

    public function show(Request $request){

    }
}
