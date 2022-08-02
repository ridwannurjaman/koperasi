<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisiModel extends Model
{
    use HasFactory;
    protected $table = "tbl_divisi";
    protected $fillable = [
        'id',
        'nama_divisi',
        'status'
    ];
}
