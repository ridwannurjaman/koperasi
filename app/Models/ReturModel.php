<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturModel extends Model
{
    use HasFactory;
    protected $table = "tbl_retur";
    protected $fillable = [
        'id',
        'id_transaksi',
        'tgl_retur',
        'total',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiModel::class,'id_transaksi','id');
    }

    public function detailBarang()
    {
        return $this->hasMany(ReturDetailModel::class,'id_retur','id');
    }
}
