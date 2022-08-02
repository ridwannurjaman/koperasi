<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use App\Models\BarangModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
Use DB;
class LaporanStockExport implements FromCollection,ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        $no = 1;
        $barang = BarangModel::orWhereHas('detailBarang' ,function ($q)
        {
            $q->whereDate('created_at', '>=', $this->from)
            ->whereDate('created_at', '<=', $this->to);
        })
        ->orWhereHas('detailTransaksi' ,function ($q)
        {
            $q->whereDate('created_at', '>=', $this->from)
            ->whereDate('created_at', '<=', $this->to);
        })
        ->orWhereHas('detailRetur' ,function ($q)
        {
            $q->whereDate('tgl_retur', '>=', $this->from)
            ->whereDate('tgl_retur', '<=', $this->to);
        })
        ->withCount([
            'detailBarang' => fn ($query) => $query->select(DB::raw('SUM(qty) as stok_pembelian'))
        ])->withCount([
            'detailTransaksi' => fn ($query) => $query->select(DB::raw('SUM(qty) as stok_penjualan'))
        
        ])->withCount([
            'detailRetur' => fn ($query) => $query->select(DB::raw('SUM(qty) as jumlah_retur'))
        ])
        ->get();
        foreach ($barang as $key => $value) {
            $stockMasuk = $value->detail_barang_count != null ? $value->detail_barang_count : 0;
            $stockKeluar = $value->detail_transaksi_count != null ? $value->detail_transaksi_count : 0;
            $stockRetur = $value->detail_retur_count != null ? $value->detail_retur_count : 0;

            $sisaStok = $stockMasuk - $stockKeluar - $stockRetur;
            $data[] = [
                'no' => $no,
                'nama_barang' => $value->nama_barang,
                'stok' => $value->stock,
                'stok_masuk' => $value->detail_barang_count != null ? $value->detail_barang_count : "0",
                'stok_keluar' => $value->detail_transaksi_count != null ? $value->detail_transaksi_count : "0",
                'stok_retur' => $value->detail_retur_count != null ? $value->detail_retur_count : "0",
                'sisa' => $sisaStok
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
            'Total Keseluruhan Stok Barang',
            'Stok Masuk',
            'Stok Keluar',
            'Stok Retur',
            'Sisa Stock Periode Ini'
        ];
    }
}
