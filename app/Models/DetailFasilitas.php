<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailFasilitas extends Model
{
    use HasFactory;
    protected $table = "detail_fasilitas";
    protected $fillable = [
        'homestay_id',
        'fasilitas_id',
        'jumlah'
    ];

}
