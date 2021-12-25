<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use stdClass;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listUnit = new stdClass();
        $itemUnit = Pembayaran::get();
        $listUnit->pembayaran = $itemUnit;
        return response()->json($listUnit);
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
            'nama_bank' => 'required',
            'no_rekening' => 'required',
            'homestay_id' => 'required',
        ]);

        $nama_bank = $request->input('nama_bank');
        $no_rekening = $request->input('no_rekening');
        $homestay_id = $request->input('homestay_id');

        $pembayarans = Pembayaran::create([
            'nama_bank' => $nama_bank,
            'no_rekening' => $no_rekening,
            'homestay_id' => $homestay_id,
        ]);

        return response()->json(['message' => 'Data Berhasil Masuk ke Tabel Pembayaran Homestay']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pembayaranList = new stdClass();
        $pembayarans = Pembayaran::where('homestay_id', $id)->select('id', 'nama_bank', 'no_rekening')->get();
        $pembayaranList->jumlah = $pembayarans->count();
        $pembayaranList->pembayaran = $pembayarans;
        return response()->json($pembayaranList);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
