<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturBarangModel extends Model
{
    use HasFactory;
    protected $table = "tbl_retur_barang";
    protected $fillable = [
        'id',
        'id_barang',
        'tgl_retur',
        'qty',
    ];

    public function barang()
    {
        return $this->belongsTo(BarangModel::class,'id_barang','id');
    }
}
