<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\ReturBarangModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class ReturBarangExport implements FromCollection,ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        $laporan = ReturBarangModel::whereDate('tgl_retur', '>=', $this->from)
                                ->whereDate('tgl_retur', '<=', $this->to)
                                ->get();
        $no = 1;
        foreach ($laporan as $key => $value) {
            $data[] = [
                'no' => $no,
                'nama_barang' => $value->barang->nama_barang,
                'qty' => $value->qty,
                'tgl_retur' => $value->tgl_retur,
            ];
            $no++;
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
            'Nama Barang',
            'Qty Retur',
            'Tanggal Retur',
        ];
    }
}
