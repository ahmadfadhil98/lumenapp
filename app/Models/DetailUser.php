<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    use HasFactory;
    protected $table = "detail_users";
    protected $fillable = [
        'nama',
        'jk',
        'no_hp',
        'tempat_lahir',
        'tgl_lahir',
        'foto'
    ];

}
