<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class LaporaTransaksiExport implements FromCollection,ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        $laporan = TransaksiModel::whereDate('created_at', '>=', $this->from)
                                ->whereDate('created_at', '<=', $this->to)
                                ->get();
        $no = 1;
        foreach ($laporan as $key => $value) {
            foreach ($value->detailBarang as $key => $val) {
                $data[] = [
                    'no' => $no,
                    'id_transaksi' => $value->id,
                    'nama_anggota' => $value->anggota != null ?$value->anggota->nama_anggota : "-",
                    'tgl_transaksi' => $value->tgl_transaksi,
                    'nama_barang' => $val->barang->nama_barang,
                    'qty' => $val->qty,
                    'total_peritem' => $val->total_peritem,
                    'metode' => $value->status
                ];
                $no++;
            }
        }
        return collect($data);
    }

    public function __construct($from,$to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function headings(): array
    {
        return [
            'No',
            'No Transaksi',
            'Nama Anggota',
            'Tanggal Transaksi',
            'Nama Barang',
            'Qty',
            'Total Harga Per Item',
            'Metode Pembayaran'
        ];
    }
}
