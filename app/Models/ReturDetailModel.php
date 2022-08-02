<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturDetailModel extends Model
{
    use HasFactory;
    protected $table = "tbl_detail_retur";
    public $incrementing = false;
    protected $fillable = [
        'id',
        'id_retur',
        'id_barang',
        'qty',
        'total_peritem',
    ];


    public function barang()
    {
        return $this->belongsTo(BarangModel::class,'id_barang','id');
    }
}
