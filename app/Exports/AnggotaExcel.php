<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\AnggotaModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class AnggotaExcel implements ToModel,WithHeadingRow
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function model(array $row)
    {
        return new AnggotaModel([
            'id' => $row['id'],
            'nama_anggota' => $row['nama'], 
            'id_jabatan' => $row['jabatan'], 
            'id_divisi' => $row['divisi'], 
            'status' => $row['status']
        ]);
    }

    
}
