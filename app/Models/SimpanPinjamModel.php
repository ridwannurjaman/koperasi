<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpanPinjamModel extends Model
{
    use HasFactory;
    protected $table = "tbl_pinjaman";
    protected $fillable = [
        'id',
        'id_anggota',
        'total_debit',
        'total_kredit'
    ];

    public function anggota()
    {
        return $this->belongsTo(AnggotaModel::class,'id_anggota','id');
    }

    public function detail()
    {
        return $this->hasMany(SimpanPinjamDetailModel::class,'id_pinjam,','id');
    }
}
