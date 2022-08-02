<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpanPinjamDetailModel extends Model
{
    use HasFactory;
    protected $table = "tbl_detail_pinjaman";
    protected $fillable = [
        'id',
        'id_pinjam',
        'total',
        'sisa',
        'jenis',
        'tanggal',
        'status',
        'deskripsi',
    ];


    
}
