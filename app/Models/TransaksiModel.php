<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    use HasFactory;
    protected $table = "tbl_transaksi";
    public $incrementing = false;
    protected $fillable = [
        'id',
        'total',
        'status',
        'tgl_transaksi',
        'id_anggota',
        'bayar',
        'kembali',
    ];

    public function anggota()
    {
        return $this->belongsTo(AnggotaModel::class,'id_anggota','id');
    }
    
    public function retur()
    {
        return $this->hasMany(ReturModel::class,'id_transaksi','id');
    }

    public function detailBarang()
    {
        return $this->hasMany(TransaksiDetailModel::class,'id_transaksi','id');
    }

    public function getTransaksiByAnggota($req)
    {
        $data = static::whereHas('anggota',function ($q) use($req)
        {
            $q->where('nama_anggota','like', '%'.$req.'%');
        })
        ->with('detailBarang' ,function ($q)
        {
            $q->with('barang');
        })
        ->with('anggota')
        ->get();
        return $data;
    }

    public function getTransaksiByid($id)
    {
        $data = static::where('id','like', '%'.$id.'%')
        ->with('detailBarang' ,function ($q)
        {
            $q->with('barang');
        })
        ->with('anggota')
        ->get();
        return $data;
    }

    
}
