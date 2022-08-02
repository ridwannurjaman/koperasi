<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnggotaModel;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use Yajra\Datatables\Datatables;
use App\Exports\LaporaTransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        return view('laporanTransaksi.index');
    }

    public function getDataTransaksi(Request $request)
    {
        $barang = TransaksiModel::all();
        // dd($barang);
        return Datatables::of($barang)
                ->addColumn('id', function ($barang) {
                    return $barang->id != null ? $barang->id : "-";
                })
                ->addColumn('total', function ($barang) {
                    $harga = $barang->total != null ? formatRupiah($barang->total) : formatRupiah(0);
                    return $harga;
                })
                ->addColumn('bayar', function ($barang) {
                    $harga = $barang->bayar != null ? formatRupiah($barang->bayar) : formatRupiah(0);
                    return $harga;
                })
                ->addColumn('kembali', function ($barang) {
                    $harga = $barang->kembali != null ? formatRupiah($barang->kembali) : formatRupiah(0);
                    return $harga;
                })
                // ->addColumn('diskon', function ($barang) {
                //     $harga = $barang->diskon != null ? formatRupiah($barang->diskon) : formatRupiah(0);
                //     return $harga;
                // })
                // ->addColumn('pajak', function ($barang) {
                //     $harga = $barang->pajak != null ? formatRupiah($barang->pajak) : formatRupiah(0);
                //     return $harga;
                // })
                ->addColumn('status', function ($barang) {
                    $harga = $barang->status != null ? $barang->status : "-";
                    return $harga;
                })
                ->addColumn('nama_anggota', function ($barang) {
                    $harga = $barang->anggota != null ? $barang->anggota->nama_anggota  : "-";
                    return $harga;
                })
                ->addColumn('tgl_transaksi', function ($barang) {
                    $harga = $barang->tgl_transaksi != null ? $barang->tgl_transaksi  : "-";
                    return $harga;
                })
                ->addColumn('action', function ($barang) {
                        return '<a href="#" class="btn btn-complete m-1 ml-2 btn_view" data-id="'.$barang->id.'"><i class="far fa-eye"
                                aria-hidden="true"></i></a>';
                    
                })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getTransaksiDetail($id)
    {
        $barang = TransaksiDetailModel::where('id_transaksi',$id)->get();
        return Datatables::of($barang)
                ->addColumn('id_transaksi', function ($barang) {
                    return $barang->id_transaksi != null ? $barang->id_transaksi : "-";
                })
                ->addColumn('nama_barang', function ($barang) {
                    $harga = $barang->barang != null ? $barang->barang->nama_barang : "-";
                    return $harga;
                })
                ->addColumn('total_peritem', function ($barang) {
                    $harga = $barang->total_peritem != null ? formatRupiah($barang->total_peritem) : formatRupiah(0);
                    return $harga;
                })
                ->addColumn('qty', function ($barang) {
                    $harga = $barang->qty != null ? formatAngka($barang->qty) : formatAngka(0);
                    return $harga;
                })
        ->make(true);
    }

    public function DownloadExportTransaksi(Request $req)
    {
        $data = (Object) [];
        try {
            $tgl = str_replace(' ', '',$req->tglTanggal);
            $tgl = explode("-",$tgl);
            $from = Carbon::createFromFormat('d/m/Y', $tgl[0])->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', $tgl[1])->format('Y-m-d');
            return Excel::download(new LaporaTransaksiExport($from,$to), 'laporanTransaksi.xlsx');
        } catch (\Throwable $th) {
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
        
    }
}
