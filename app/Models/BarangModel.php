<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;
    protected $table = "tbl_barang";
    public $incrementing = false;
    protected $fillable = [
        'id',
        'no_barcode',
        'nama_barang',
        'kategori_barang',
        'harga',
        'stock',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class,'kategori_barang','id');
    }

    public function detailBarang()
    {
        return $this->hasMany(PembelianBarangModel::class,'id_barang','id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(TransaksiDetailModel::class,'id_barang','id');
    }

    public function detailRetur()
    {
        return $this->hasMany(ReturBarangModel::class,'id_barang','id');
    }

    public function getBarangBarcode($barcode)
    {
        $data = static::where('no_barcode','like', '%'.$barcode.'%')->get();
        return $data;
    }

    public function getBarangByName($nama)
    {
        $data = static::where('nama_barang','like', '%'.$nama.'%')->get();
        return $data;
    }
}
