<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetailModel extends Model
{
    use HasFactory;
    protected $table = "tbl_detail_transaksi";
    protected $fillable = [
        'id',
        'id_transaksi',
        'id_barang',
        'qty',
        'total_peritem'
    ];

    public function barang()
    {
        return $this->belongsTo(BarangModel::class,'id_barang','id');
    }
}
