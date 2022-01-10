<?php

namespace App\Http\Controllers;

use App\Models\DetailUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // $validator = $this->validate($request, [
        //     'username' =>'required|unique:users,username',
        //     'email' => 'required|unique:users|email',
        //     'password' => 'required|min:6'
        // ]);
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }

        $username = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $generateToken = bin2hex(random_bytes(40));
        $fcm_token = $request->input('fcm_token');

        $user = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'token' => $generateToken,
            'fcm_token' => $fcm_token
        ]);

        // $duser = DetailUser::create([
        //     'id' => $user->id
        // ]);

        return response()->json([
            'message' => 'Pendaftaran pengguna berhasil dilaksanakan',
            'id' => $user->id,
            'token' => $user->token
        ]);
    }

    public function show($id)
    {
    }

    public function otp($phone)
    {
        $duser = DetailUser::where('no_hp', $phone)->first();

        if (!$duser) {
            return response()->json([
                'message' => 'Nomor ini tidak terdaftar'
            ]);
        }

        return response()->json([
            'id' => $duser->id
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $duser = DetailUser::where('id', $id)->first();

        $email = $request->input('email');
        $username = $request->input('username');

        if ($request->input('password') != null) {
            $password = Hash::make($request->input('password'));

            $user->update([
                'password' => $password
            ]);
        } else {

            if ($request->input('foto') != null) {
                $foto = $request->input('foto');
                $nama = $duser->nama;
                $jk = $duser->jk;
                $no_hp = $duser->no_hp;
                $tempat_lahir = $duser->tempat_lahir;
                $tgl_lahir = $duser->tgl_lahir;
                $date = $tgl_lahir;
            } else {
                $foto = $duser->foto;
                $nama = $request->input('nama');
                $jk = $request->input('jk');
                $no_hp = $request->input('no_hp');
                $tempat_lahir = $request->input('tempat_lahir');
                $tgl_lahir = $request->input('tgl_lahir');

                if ($tgl_lahir != null) {
                    $date = Carbon::createFromFormat('d/m/Y', $tgl_lahir)->format('Y-m-d');
                } else {
                    $date = null;
                }
            }

            if ($email != null) {

                $user->update([
                    'email' => 'user@mailis.com'
                ]);

                $validator = Validator::make($request->all(), [
                    'email' => 'required|unique:users|email',
                ]);
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 200);
                }

                $user->update([
                    'email' => $email
                ]);
            }

            if ($username != null) {

                $user->update([
                    'username' => 'usernamedummy'
                ]);

                $validator = Validator::make($request->all(), [
                    'username' => 'required|unique:users,username',
                ]);
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 200);
                }

                $user->update([
                    'username' => $username
                ]);
            }


            $duser->update([
                'nama' => $nama,
                'jk' => $jk,
                'no_hp' => $no_hp,
                'tempat_lahir' => $tempat_lahir,
                'tgl_lahir' => $date,
                'foto' => $foto,
            ]);
        }

        return response()->json([
            'message' => 'Update pengguna berhasil dilaksanakan'
        ]);
    }
}
