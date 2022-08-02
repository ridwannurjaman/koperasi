<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBarangModel extends Model
{
    use HasFactory;
    protected $table = "tbl_pembelian_barang";
    protected $fillable = [
        'id',
        'id_barang',
        'harga',
        'qty',
        'tgl_beli',
    ];
}
