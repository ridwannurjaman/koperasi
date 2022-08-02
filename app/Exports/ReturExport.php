<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\ReturModel;
use App\Models\ReturDetailModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class ReturExport implements FromCollection,ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        $laporan = ReturModel::whereDate('created_at', '>=', $this->from)
                                ->whereDate('created_at', '<=', $this->to)
                                ->get();
        $no = 1;
        foreach ($laporan as $key => $value) {
            foreach ($value->detailBarang as $key => $val) {
                $data[] = [
                    'no' => $no,
                    'id_transaksi' => $value->transaksi->id,
                    'nama_anggota' => $value->transaksi->anggota != null ? $value->transaksi->anggota->nama_anggota : "-",
                    'tgl_transaksi' => $value->transaksi->tgl_transaksi,
                    'tgl_retur' => $value->tgl_retur,
                    'nama_barang' => $val->barang->nama_barang,
                    'qty' => $val->qty,
                    'total_peritem' => $val->total_peritem,
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
            'Tanggal Retur',
            'Nama Barang',
            'Qty Retur',
            'Total Per Item',
        ];
    }
}
