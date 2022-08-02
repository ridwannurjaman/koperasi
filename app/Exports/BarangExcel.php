<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\BarangModel;
use App\Models\PembelianBarangModel;
class BarangExcel implements ToModel,WithHeadingRow
{
    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection(Collection $rows)
//     {
//         try {
//             foreach ($rows as $row) {
//                 $id = IdGenerator::generate(['table' => 'tbl_barang', 'length' => 5, 'prefix' => 'K']);
//                 $dataBarang = BarangModel::create([
//                     'id' => $id,
//                     'no_barcode' => $row[1],
//                     'nama_barang' => $row['nama_barang'],
//                     'harga' => (int)$row['harga_jual'],
//                     'status' => 1,
//                     'jenis_unit' => $row['jenis_unit'],
//                     'stock' =>  (int)$row['stock']
//                 ]);
//                 $dataBarangDetail = PembelianBarangModel::create([
//                     'id_barang' => $id,
//                     'harga' => (int)$row['harga_beli'],
//                     'qty' => (int)$row['stock'],
//                     'tgl_beli' => date('Y-m-d',$row['tanggal_beli'])
//                 ]);
//             }
//         } catch (\Throwable $th) {
//             throw $th;
//         }
       
//     }

    public function model(array $row)
    {   
        try {
            $id = IdGenerator::generate(['table' => 'tbl_barang', 'length' => 5, 'prefix' => 'K']);
            $data = new BarangModel();
            $data->id = $id;
            $data->nama_barang = isset($row['nama']) ? $row['nama'] : '-';
            $data->no_barcode = isset($row['barcode']) ? $row['barcode'] : null;
            $data->harga = isset($row['hargajual']) ? $row['hargajual'] : null;
            $data->stock = (int)isset($row['stock']) ? $row['stock'] : null;
            $data->jenis_unit = isset($row['jenisunit']) ? $row['jenisunit'] : null;
            $data->status = 1;
            $data->save();

            $tglbeli = isset($row['tanggalbeli']) ? $row['tanggalbeli'] : null;
            $miliseconds = ($tglbeli - (25567 + 2)) * 86400 * 1000;
            $seconds = $miliseconds / 1000;
            return new PembelianBarangModel([
                    'id_barang' => $id,
                    'harga' => isset($row['hargabeli']) ? $row['hargabeli'] : null,
                    'qty' => isset($row['stock']) ? $row['stock'] : null,
                    'tgl_beli' => date("Y-m-d", $seconds)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
