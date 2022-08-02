<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayarDetailModel extends Model
{
    use HasFactory;
    protected $table = "tbl_detail_bayar";
    protected $fillable = [
        'id',
        'id_detail_pinjam',
        'bayar',
    ];
}
