<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DivisiModel;
use App\Models\JabatanModel;

class AnggotaModel extends Model
{
    use HasFactory;
    protected $table = "tbl_anggota";
    public $incrementing = false;
    protected $fillable = [
        'id',
        'nama_anggota',
        'alamat',
        'no_hp',
        'jk',
        'id_jabatan',
        'id_divisi',
        'status'
    ];

    public function jabatan()
    {
        return $this->belongsTo(JabatanModel::class,'id_jabatan','id');
    }
    public function divisi()
    {
        return $this->belongsTo(DivisiModel::class,'id_divisi','id');
    }

    public function getAnggotaBarcode($noAnggota)
    {
        $data = static::where('status','Aktif')->where('id','like', '%'.$noAnggota.'%')->get();
        return $data;
    }

    public function getAnggotaByNama($nama)
    {
        $data = static::where('status','Aktif')->where('nama_anggota','like', '%'.$nama.'%')->get();
        return $data;
    }

}
