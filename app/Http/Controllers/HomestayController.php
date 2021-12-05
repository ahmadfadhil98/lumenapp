<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        ->select('homestays.id','nama','jenis','foto','latitude','longitude',
        DB::raw('(SELECT AVG(rating) from reviews where reviews.homestay_id = homestays.id) as rating'))
        ->get();
        // $homestay = DB::select('select * from homestays join jenis on jenis.id=homestays.jenis_id');
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
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $keterangan = $request->input('keterangan');

        $homestay = Homestay::create([
            'jenis_id' => $jenis_id,
            'nama' => $nama,
            'alamat' => $alamat,
            'foto' => $foto,
            'no_hp' => $no_hp,
            'website' => $website,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'keterangan' => $keterangan
        ]);

        return response()->json(['message' => 'Data Berhasil Masuk ke Tabel Homestay']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Homestay  $homestay
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $home = new stdClass();
        $homeItem = Homestay::join('jenis','jenis.id','=','homestays.jenis_id')
        ->where('homestays.id',$id)
        ->select('homestays.id','nama','jenis','alamat','website','no_hp','foto',
        DB::raw('(SELECT AVG(rating) from reviews where reviews.homestay_id = homestays.id) as rating'))
        ->get();
        $home->home = $homeItem;
        return response()->json($home);
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
