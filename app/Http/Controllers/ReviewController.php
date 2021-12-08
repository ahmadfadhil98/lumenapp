<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use stdClass;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listReview = new stdClass();
        $itemReview = Review::get();
        $listReview->detail_user = $itemReview;
        return response()->json($listReview);
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
            'user_id' =>'required',
            'homestay_id' => 'required'
        ]);

        $user_id = $request->input('user_id');
        $homestay_id = $request->input('homestay_id');
        $rating = $request->input('rating');
        $komentar = $request->input('komentar');

        $review = Review::create([
            'user_id' => $user_id,
            'homestay_id' => $homestay_id,
            'rating' => $rating,
            'komentar' => $komentar,
        ]);

        return response()->json(['message' => 'Data Berhasil Masuk ke Tabel Review']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $listReview = new stdClass();
        $review = Review::join('detail_users','detail_users.id','=','reviews.user_id')
        ->join('homestays','homestays.id','=','reviews.homestay_id')
        ->where('reviews.homestay_id','=',$id)
        ->select('detail_users.nama','reviews.komentar','reviews.rating','reviews.homestay_id','reviews.updated_at','detail_users.foto')
        ->get();
        $listReview->review = $review;
        return response()->json($listReview);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
