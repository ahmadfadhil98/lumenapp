<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = "bookings";
    protected $fillable = [
        'user_id',
        'unit_id',
        'check_in',
        'check_out',
        'status',
        'pembayaran_id',
        'token'
    ];
}
