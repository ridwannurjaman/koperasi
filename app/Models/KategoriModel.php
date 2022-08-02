<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;
    protected $table = "tbl_kategori";
    protected $fillable = [
        'id',
        'nama_kategori',
        'status'
    ];
}
