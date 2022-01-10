<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Homestay;
use App\Models\Notifikasi;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    }

    public function belum()
    {
        $listBooking = new stdClass();
        $booking = Booking::where('bookings.status', '=', 1)
            ->join('pembayarans', 'pembayarans.id', '=', 'bookings.pembayaran_id')
            ->join('units', 'units.id', '=', 'bookings.unit_id')
            ->select('bookings.id', 'pembayarans.nama_bank', 'pembayarans.no_rekening', 'bookings.token', 'units.harga')
            ->get();
        $listBooking->list_booking = $booking;
        return response()->json($listBooking);
    }

    public function sudah()
    {
        $listBooking = new stdClass();
        $booking = Booking::where('bookings.status', '=', 2)
            ->join('pembayarans', 'pembayarans.id', '=', 'bookings.pembayaran_id')
            ->join('units', 'units.id', '=', 'bookings.unit_id')
            ->select('bookings.id', 'pembayarans.nama_bank', 'pembayarans.no_rekening', 'bookings.token', 'units.harga')
            ->get();
        $listBooking->list_booking = $booking;
        return response()->json($listBooking);
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
            'unit_id' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'pembayaran_id' => 'required'
        ]);

        $auth = Auth::user();

        $user_id = $auth->id;

        $unit_id = $request->input('unit_id');
        $check_in = $request->input('check_in');
        $check_out = $request->input('check_out');
        $pembayaran_id = $request->input('pembayaran_id');

        $generateToken = bin2hex(random_bytes(10));

        $booking = Booking::create([
            'user_id' => $user_id,
            'unit_id' => $unit_id,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'pembayaran_id' => $pembayaran_id,
            'token' => $generateToken
        ]);

        return response()->json([
            'message' => 'Data Berhasil Masuk ke Tabel Detail Fasilitas',
            'id' => $booking->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dBooking = new stdClass();
        $booking = Booking::where('bookings.id', $id)
            ->join('pembayarans', 'pembayarans.id', '=', 'bookings.pembayaran_id')
            ->join('units', 'units.id', '=', 'bookings.unit_id')
            ->select('pembayarans.nama_bank', 'pembayarans.no_rekening', 'bookings.token', 'units.harga', 'bookings.check_in', 'bookings.check_out')->get();
        $dBooking->detail_booking = $booking;
        return response()->json($dBooking);
    }

    public function reminder($id)
    {
        $booking = Booking::find($id);
        $user = User::find($booking->user_id);
        $unit = Unit::find($booking->unit_id);
        $homestay = Homestay::find($unit->homestay_id);

        $notifikasi = new stdClass();
        $notifikasi->title = "Pengingat";
        $notifikasi->message = "Hei kawan, mau ingetin nih, homestay yang di booking belum di-DP, nanti di ambil ama orang lain lo";

        $notif = Notifikasi::create([
            'user_id' => $user->id,
            'title' => $notifikasi->title,
            'message' => $notifikasi->message
        ]);

        return view('notifikasi.notiifikasi', compact('booking', 'user', 'notifikasi', 'homestay'));
    }

    public function booking($id)
    {

        $booking = Booking::find($id);
        $user = User::find($booking->user_id);
        $unit = Unit::find($booking->unit_id);
        $homestay = Homestay::find($unit->homestay_id);
        $notifikasi = new stdClass();
        $notifikasi->title = "Selamat";
        $notifikasi->message = "Pembayaran kamu berhasil, sampai jumpa di tempat ya";

        $booking->update([
            'status' => 2
        ]);

        $notif = Notifikasi::create([
            'user_id' => $user->id,
            'title' => $notifikasi->title,
            'message' => $notifikasi->message
        ]);

        return view('notifikasi.notiifikasi', compact('booking', 'user', 'notifikasi', 'homestay'));
    }

    public function cancel($id)
    {

        $booking = Booking::find($id);
        $user = User::find($booking->user_id);
        $unit = Unit::find($booking->unit_id);
        $homestay = Homestay::find($unit->homestay_id);
        $notifikasi = new stdClass();
        $notifikasi->title = "Pemberitahuan";
        $notifikasi->message = "Dikarenakan anda belum melakukan pembayaran, dengan berat hati kami membatalkan booking anda";

        $booking->update([
            'status' => 3
        ]);

        $notif = Notifikasi::create([
            'user_id' => $user->id,
            'title' => $notifikasi->title,
            'message' => $notifikasi->message
        ]);

        return view('notifikasi.notiifikasi', compact('booking', 'user', 'notifikasi', 'homestay'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
