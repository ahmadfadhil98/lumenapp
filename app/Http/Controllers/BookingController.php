<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Homestay;
use App\Models\Notifikasi;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $dBooking = new stdClass();
        $booking = Booking::where('bookings.status', '=', 1)
            ->join('pembayarans', 'pembayarans.id', '=', 'bookings.pembayaran_id')
            ->join('homestays', 'homestays.id', '=', 'bookings.homestay_id')
            ->select(
                'bookings.id',
                'pembayarans.nama_bank',
                'pembayarans.no_rekening',
                'bookings.token',
                'bookings.check_in',
                'bookings.check_out',
                DB::raw('(SELECT SUM(units.harga) from detail_bookings JOIN units on units.id=detail_bookings.unit_id WHERE detail_bookings.booking_id=bookings.id) as tarif')
            )->get();
        $dBooking->list_booking = $booking;

        return response()->json($dBooking);
    }

    public function sudah()
    {
        $dBooking = new stdClass();
        $booking = Booking::where('bookings.status', '=', 2)
            ->join('pembayarans', 'pembayarans.id', '=', 'bookings.pembayaran_id')
            ->join('homestays', 'homestays.id', '=', 'bookings.homestay_id')
            ->select(
                'bookings.id',
                'pembayarans.nama_bank',
                'pembayarans.no_rekening',
                'bookings.token',
                'bookings.check_in',
                'bookings.check_out',
                DB::raw('(SELECT SUM(units.harga) from detail_bookings JOIN units on units.id=detail_bookings.unit_id WHERE detail_bookings.booking_id=bookings.id) as tarif')
            )->get();
        $dBooking->list_booking = $booking;

        return response()->json($dBooking);
    }

    public function history()
    {
        $dBooking = new stdClass();
        $auth = Auth::user();

        $booking = Booking::where('bookings.user_id', $auth->id)
            ->join('pembayarans', 'pembayarans.id', '=', 'bookings.pembayaran_id')
            ->join('homestays', 'homestays.id', '=', 'bookings.homestay_id')
            ->select(
                'bookings.id',
                'pembayarans.nama_bank',
                'pembayarans.no_rekening',
                'bookings.token',
                'bookings.check_in',
                'bookings.check_out',
                'homestays.nama',
                'bookings.homestay_id',
                'bookings.updated_at',
                'bookings.status',
                DB::raw('(SELECT SUM(units.harga) from detail_bookings JOIN units on units.id=detail_bookings.unit_id WHERE detail_bookings.booking_id=bookings.id) as tarif')
            )->get();
        $dBooking->list_booking = $booking;

        return response()->json($dBooking);
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
            'homestay_id' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'pembayaran_id' => 'required'
        ]);

        $units = $request->input('units');

        $auth = Auth::user();

        $user_id = $auth->id;

        $homestay_id = $request->input('homestay_id');
        $check_in = $request->input('check_in');
        $check_out = $request->input('check_out');
        $pembayaran_id = $request->input('pembayaran_id');

        $generateToken = bin2hex(random_bytes(10));

        $booking = Booking::create([
            'user_id' => $user_id,
            'homestay_id' => $homestay_id,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'pembayaran_id' => $pembayaran_id,
            'token' => $generateToken
        ]);

        foreach ($units as $unit) {
            DetailBooking::create([
                'booking_id' => $booking->id,
                'unit_id' => $unit
            ]);
        }

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
            ->join('homestays', 'homestays.id', '=', 'bookings.homestay_id')
            ->select('pembayarans.nama_bank', 'pembayarans.no_rekening', 'bookings.token', 'bookings.check_in', 'bookings.check_out')->first();
        $unit = DetailBooking::where('booking_id', $id)
            ->join('units', 'units.id', '=', 'detail_bookings.unit_id')
            ->select('units.nama', 'units.harga')
            ->get();
        $dBooking->detail_booking = $booking;
        $dBooking->unit_booking = $unit;
        return response()->json($dBooking);
    }

    public function reminder($id)
    {
        $booking = Booking::find($id);
        $user = User::find($booking->user_id);
        $homestay = Homestay::find($booking->homestay_id);

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
        $homestay = Homestay::find($booking->homestay_id);
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
        $homestay = Homestay::find($booking->homestay_id);
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
