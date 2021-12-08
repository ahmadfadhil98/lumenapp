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

    public function update(Request $request, $id)
    {
        $user = User::where('id',$id)->first();
        $duser = DetailUser::where('id',$id)->first();

        $email = $request->input('email');
        if($request->input('password')!=null){
            $password = Hash::make($request->input('password'));
        }else{
            $password = $user->password;
        }

        $nama = $request->input('nama');
        $jk = $request->input('jk');
        $no_hp = $request->input('no_hp');
        $tempat_lahir = $request->input('tempat_lahir');
        $tgl_lahir = $request->input('tgl_lahir');

        if($request->input('foto')!=null){
            $foto = $request->input('foto');
        }else{
            $foto = $duser->foto;
        }



        if($tgl_lahir!=null){
            $date = Carbon::createFromFormat('d/m/Y', $tgl_lahir)->format('Y-m-d');
        }else{
            $date = null;
        }

        if ($email!=null){
            $user->update([
                'email' => 'user@mail.com'
            ]);

            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:users|email',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors() , 200);
            }

            $user->update([
                'email' => $email
            ]);
        }

        $user->update([
            'password' => $password
        ]);

        $duser->update([
            'nama' => $nama,
            'jk' => $jk,
            'no_hp' => $no_hp,
            'tempat_lahir' => $tempat_lahir,
            'tgl_lahir' => $date,
            'foto' => $foto,
        ]);

        return response()->json([
            'message' => 'Update pengguna berhasil dilaksanakan'
        ]);
    }
}
