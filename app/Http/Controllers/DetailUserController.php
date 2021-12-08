<?php

namespace App\Http\Controllers;

use App\Models\DetailUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class DetailUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listUser = new stdClass();
        $itemUser = DetailUser::get();
        $listUser->detail_user = $itemUser;
        return response()->json($listUser);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_hp' => 'unique:detail_users,no_hp'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors() , 200);
        }

        $id = $request->input('id');
        $nama = $request->input('nama');
        $jk = $request->input('jk');
        $no_hp = $request->input('no_hp');
        $tempat_lahir = $request->input('tempat_lahir');
        $tgl_lahir = $request->input('tgl_lahir');
        $foto = $request->input('foto');

        if($tgl_lahir!=null){
            $date = Carbon::createFromFormat('d/m/Y', $tgl_lahir)->format('Y-m-d');
        }else{
            $date = null;
        }

        $detailUser = DetailUser::create([
            'id' => $id,
            'nama' => $nama,
            'jk' => $jk,
            'no_hp' => $no_hp,
            'tempat_lahir' => $tempat_lahir,
            'tgl_lahir' => $date   ,
            'foto' => $foto,
        ]);

        return response()->json(['message' => 'Data Berhasil Masuk ke Tabel Detail User']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailUser  $detailUser
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('token',$id)->first();

        $listUser = new stdClass();
        $itemUser = DetailUser::join('users','users.id','=','detail_users.id')
        ->where('users.token',$id)
        ->select('detail_users.*','email','username')
        ->get();
        $listUser->idUser = $user->id;
        $listUser->detail_user = $itemUser;
        return response()->json($listUser);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailUser  $detailUser
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailUser $detailUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailUser  $detailUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailUser $detailUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailUser  $detailUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailUser $detailUser)
    {
        //
    }
}
