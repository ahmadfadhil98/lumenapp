<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBooking extends Model
{
    use HasFactory;
    protected $table = "detail_bookings";
    protected $fillable = [
        'booking_id',
        'unit_id'
    ];
}
