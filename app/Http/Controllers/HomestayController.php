<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use Illuminate\Http\Request;
use stdClass;

class HomestayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $listHomestay = new stdClass();
        $homestay = Homestay::join('jenis','jenis.id','=','homestays.jenis_id')
        ->get();

        $listHomestay->homestay = $homestay;
        return response()->json($listHomestay);
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
        $this->validate($request, [
            'jenis_id' =>'required',
            'nama' => 'required',
            'no_hp' => 'required'
        ]);

        $jenis_id = $request->input('jenis_id');
        $nama = $request->input('nama');
        $alamat = $request->input('alamat');
        $foto = $request->input('foto');
        $no_hp = $request->input('no_hp');
        $website = $request->input('website');
        $point = $request->input('point');

        $homestay = Homestay::create([
            'jenis_id' => $jenis_id,
            'nama' => $nama,
            'alamat' => $alamat,
            'foto' => $foto,
            'no_hp' => $no_hp,
            'website' => $website,
            'point' => $point
        ]);

        return response()->json(['message' => 'Data Berhasil Masuk ke Tabel Homestay']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Homestay  $homestay
     * @return \Illuminate\Http\Response
     */
    public function show(Homestay $homestay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homestay  $homestay
     * @return \Illuminate\Http\Response
     */
    public function edit(Homestay $homestay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Homestay  $homestay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homestay $homestay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Homestay  $homestay
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homestay $homestay)
    {
        //
    }
}
