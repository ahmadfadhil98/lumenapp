<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $fcm_token = $request->input('fcm_token');

        $user = User::where('username', $username)->orWhere('email', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken,
            'fcm_token' => $fcm_token
        ]);

        $api = new \stdClass();
        $api->data = $user;
        return response()->json($api);
    }

    public function login_hp(Request $request)
    {

        $id = $request->input('id_user');
        $fcm_token = $request->input('fcm_token');

        $user = User::where('id', $id)->first();

        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken,
            'fcm_token' => $fcm_token
        ]);

        $api = new \stdClass();
        $api->data = $user;
        return response()->json($api);
    }

    public function logout(Request $request)
    {
        $auth = Auth::user();

        $user = User::where('id', $auth->id)->first();
        $user->update([
            'token' => null,
            'fcm_token' => null
        ]);
        $user->save();

        return response()->json(['message' => 'Pengguna telah logout']);
    }
}
