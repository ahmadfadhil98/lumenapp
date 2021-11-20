<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    use HasFactory;
    protected $table = "homestays";
    protected $fillable = [
        'jenis_id',
        'nama',
        'alamat',
        'foto',
        'no_hp',
        'website',
        'point',
        'keterangan'
    ];

}
