<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use App\Models\BarangModel;
use App\Models\ReturModel;
use App\Models\ReturBarangModel;
use App\Models\ReturDetailModel;
use Yajra\Datatables\Datatables;
use App\Exports\ReturExport;
use App\Exports\ReturBarangExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class ReturController extends Controller
{
    public function index()
    {
        return view('retur.index');
    }

    public function retur()
    {
        return view('retur.laporan');
    }
    public function retur_barang()
    {
        return view('retur.lapraon_retur_barang');
    }

    public function returBarang(Request $req)
    {
        if($req->switch == "true"){
            $transaksi = TransaksiModel::getTransaksiByAnggota($req->search);
        }else{
            $transaksi = TransaksiModel::getTransaksiByid($req->search);
        }

        $data= [];

        foreach ($transaksi as $key => $value) {
            $barang = [];
            foreach ($value->detailBarang as $key => $bar) {
                $barang[] = [
                    'nama_barang' => $bar->barang->nama_barang,
                    'harga' => $bar->barang->harga,
                    'qty' => $bar->qty,
                    'total_peritem' => $bar->total_peritem,
                    'id_barang' => $bar->id_barang,
                    'id' => $bar->id
                ];
            }
            $data []= [
                'id' => $value->id,
                'nama_anggota' =>$req->switch == "true" || $value->anggota != null  ? $value->anggota->nama_anggota : '-',
                'total_transaksi' => formatRupiah($value->total),
                'bayar' => $value->bayar,
                'tgl_transaksi' => $value->tgl_transaksi,
                'barang' => $barang,
                'id_anggota' =>$req->switch == "true" || $value->anggota != null  ? $value->anggota->id : '-',
            ];
        };
        
        return $data;
    }

    public function getDataRetur(Request $request)
    {
        $retur = ReturModel::all();
        return Datatables::of($retur)
                ->addColumn('id', function ($retur) {
                    return $retur->id_transaksi;
                })
                ->addColumn('total', function ($retur) {
                    $harga = $retur->total != null ? formatRupiah($retur->total) : formatRupiah(0);
                    return $harga;
                })
                ->addColumn('nama_anggota', function ($retur) {
                    $harga = $retur->transaksi->anggota != null ? $retur->transaksi->anggota->nama_anggota  : "-";
                    return $harga;
                })
                ->addColumn('tgl_transaksi', function ($retur) {
                    $harga = $retur->transaksi != null ? $retur->transaksi->tgl_transaksi  : "-";
                    return $harga;
                })
                ->addColumn('tgl_retur', function ($retur) {
                    $harga = $retur->tgl_retur != null ? $retur->tgl_retur : "-";
                    return $harga;
                })
                ->addColumn('action', function ($retur) {
                        return '<a href="#" class="btn btn-complete m-1 ml-2 btn_view" data-id="'.$retur->id.'"><i class="far fa-eye"
                                aria-hidden="true"></i></a>';
                })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getDataReturBarang(Request $request)
    {
        $retur = ReturBarangModel::all();
        return Datatables::of($retur)
                ->addColumn('qty', function ($retur) {
                    $harga = $retur->qty != null ? $retur->qty : 0;
                    return $harga;
                })
                ->addColumn('tgl_retur', function ($retur) {
                    $harga = $retur->tgl_retur != null ? $retur->tgl_retur : "-";
                    return $harga;
                })
                ->addColumn('nama_barang', function ($retur) {
                    $harga = $retur->barang->nama_barang != null ? $retur->barang->nama_barang : "-";
                    return $harga;
                })
                ->addColumn('action', function ($retur) {
                        return '<a href="#" class="btn btn-complete m-1 ml-2 btn_view" data-id="'.$retur->id.'"><i class="far fa-eye"
                                aria-hidden="true"></i></a>';
                })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getDetailRetur($id)
    {
        $retur = ReturDetailModel::where('id_retur',$id)->get();
        return Datatables::of($retur)
                ->addColumn('id', function ($retur) {
                    return $retur->id != null ? $retur->id : "-";
                })
                ->addColumn('nama_barang', function ($retur) {
                    $harga = $retur->barang != null ? $retur->barang->nama_barang : "-";
                    return $harga;
                })
                ->addColumn('total_peritem', function ($retur) {
                    $harga = $retur->total_peritem != null ? formatRupiah($retur->total_peritem) : formatRupiah(0);
                    return $harga;
                })
                ->addColumn('qty', function ($retur) {
                    $harga = $retur->qty != null ? formatAngka($retur->qty) : formatAngka(0);
                    return $harga;
                })
        ->make(true);
    }

    public function save(Request $request)
    {
        $res = (Object)[];
        try {

            $retur = new ReturModel();
            $retur->id_transaksi = $request->idTransaksi;
            $retur->total = $request->total;
            $retur->tgl_retur = date('Y-m-d H:i:s');
            $retur->save();
            $id = $retur->id;

            foreach ($request->dataBarang as $key => $value) {
                $returDetail = new ReturDetailModel();
                $returDetail->id_retur = $id;
                $returDetail->id_barang = $value['id_barang'];
                $returDetail->qty = $value['qty'];
                $returDetail->total_peritem = $value['total_harga'];
                $returDetail->save();

                // TransaksiDetailModel::where('id',$value['id'])->decrement('qty',$value['qty'],[
                //     'status_retur' => '1',
                // ]);
                TransaksiDetailModel::where('id',$value['id'])->update([
                    'status_retur' => '1',
                ]);
            }

            $res->code = 200;
            $res->message = "Berhasil Simpan";
            return $res;
        }catch (\Throwable $th) {
            $res->code = 500;
            $res->message = $th->getMessage();
            return $res;
        }
    }

    public function DownloadExportRetur(Request $req)
    {
        $data = (Object) [];
        try {
            $tgl = str_replace(' ', '',$req->tglTanggal);
            $tgl = explode("-",$tgl);
            $from = Carbon::createFromFormat('d/m/Y', $tgl[0])->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', $tgl[1])->format('Y-m-d');
            return Excel::download(new ReturExport($from,$to), 'laporanRetur'.$from.'-'.$to.'.xlsx');
        } catch (\Throwable $th) {
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
        
    }

    public function DownloadExportReturBarang(Request $req)
    {
        $data = (Object) [];
        try {
            $tgl = str_replace(' ', '',$req->tglTanggal);
            $tgl = explode("-",$tgl);
            $from = Carbon::createFromFormat('d/m/Y', $tgl[0])->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', $tgl[1])->format('Y-m-d');
            return Excel::download(new ReturBarangExport($from,$to), 'laporan Retur Barang'.$from.'-'.$to.'.xlsx');
        } catch (\Throwable $th) {
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
        
    }
}
