<?php

namespace App\Http\Controllers;

use App\Models\DetailFasilitas;
use Illuminate\Http\Request;
use stdClass;

class DetailFasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listUser = new stdClass();
        $itemUser = DetailFasilitas::get();
        $listUser->detail_fasilitas = $itemUser;
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
        $this->validate($request, [
            'fasilitas_id' => 'required',
            'homestay_id' => 'required',
            'jumlah' => 'required'
        ]);

        $fasilitas_id = $request->input('fasilitas_id');
        $homestay_id = $request->input('homestay_id');
        $jumlah = $request->input('jumlah');

        $detailFasilitas = DetailFasilitas::create([
            'fasilitas_id' => $fasilitas_id,
            'homestay_id' => $homestay_id,
            'jumlah' => $jumlah,
        ]);

        return response()->json(['message' => 'Data Berhasil Masuk ke Tabel Detail Fasilitas']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailFasilitas  $detailFasilitas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dFasilitas = new stdClass();
        $detailFasilitas = DetailFasilitas::join('fasilitas', 'fasilitas.id', '=', 'detail_fasilitas.fasilitas_id')
            ->join('homestays', 'homestays.id', '=', 'detail_fasilitas.homestay_id')
            ->where('detail_fasilitas.homestay_id', $id)
            ->select('fasilitas.nama', 'detail_fasilitas.fasilitas_id', 'detail_fasilitas.homestay_id', 'detail_fasilitas.jumlah')
            ->get();
        $dFasilitas->fasilitas_homestay = $detailFasilitas;
        return response()->json($dFasilitas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailFasilitas  $detailFasilitas
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailFasilitas $detailFasilitas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailFasilitas  $detailFasilitas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailFasilitas $detailFasilitas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailFasilitas  $detailFasilitas
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailFasilitas $detailFasilitas)
    {
        //
    }
}
