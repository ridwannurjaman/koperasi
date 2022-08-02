<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\AnggotaModel;
use App\Models\TransaksiModel;
use App\Models\SimpanPinjamModel;
use App\Models\SimpanPinjamDetailModel;
use App\Models\TransaksiDetailModel;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
class KasirController extends Controller
{
    public function index(Request $req)
    {
        $id = IdGenerator::generate(['table' => 'tbl_transaksi','length' => 6, 'prefix' => 'TR']);
        $date = Carbon::now()->isoFormat('D MMMM Y');
        return view('kasir.index',compact('id','date'));
    }

    public function searchBarang(Request $req)
    {
        if($req->barcode == 1){
            $barang = BarangModel::getBarangBarcode($req->search);
        }else{
            $barang = BarangModel::getBarangByName($req->search);
        }
        
        return $barang;
    }

    public function searchAnggota(Request $req)
    {
        if($req->barcode == 1){
            $barang = AnggotaModel::getAnggotaBarcode($req->search);
        }else{
            $barang = AnggotaModel::getAnggotaByNama($req->search);
        }
        
        return $barang;
    }

    public function saveTransaksi(Request $req)
    {
        $res = (Object)[];
        try {
            
            $nomor_transaksi = IdGenerator::generate(['table' => 'tbl_transaksi', 'length' => 6, 'prefix' => 'TR']);
            $data = new TransaksiModel();
            $data->id = $nomor_transaksi;
            $data->total = $req->total;
            $data->bayar = $req->bayar;
            $data->kembali = $req->kembali;
            $data->tgl_transaksi = date('Y-m-d H:i:s');
            if($req->idAnggota != null){
                $data->id_anggota = $req->idAnggota;
                if($req->status_bayar == 'Kredit'){
                    $cekData = SimpanPinjamModel::where('id_anggota', $req->idAnggota)->first();
                    if($cekData != null){
                        $idCek = $cekData->id;
                        $dataPinjaman = SimpanPinjamModel::where('id',$cekData->id)->update([
                            'total_kredit'=>$cekData->total_kredit+$req->total ,
                        ]);
                    }else{
                        $dataPinjaman = new SimpanPinjamModel();
                        $dataPinjaman->id_anggota =  $req->idAnggota;
                        $dataPinjaman->total_kredit = $req->total;
                        $dataPinjaman->total_debit = 0;
                        $dataPinjaman->save();
                        $idCek = $dataPinjaman->id;
                        
                    }
                    $dataPinjamanDetail = new SimpanPinjamDetailModel();
                    $dataPinjamanDetail->tanggal = date('Y-m-d H:i:s');
                    $dataPinjamanDetail->jenis = 'kredit';
                    $dataPinjamanDetail->id_pinjam = $idCek;
                    $dataPinjamanDetail->total = $req->total;
                    $dataPinjamanDetail->sisa =  $req->total;
                    $dataPinjamanDetail->deskripsi = "Membeli Barang / Belanja di koperasi";
                    $dataPinjamanDetail->status = "Belum Lunas";
                    $dataPinjamanDetail->save();
                }
            }
            $data->status = $req->status_bayar;
            $data->save();
            $id = $data->id;
            foreach ($req->dataBarang as $key => $value) {
                $dataDetail = new TransaksiDetailModel();
                $dataDetail->id_transaksi = $id;
                $dataDetail->id_barang = $value['id'];
                $dataDetail->qty = $value['qty'];
                $dataDetail->total_peritem = $value['total_harga'];
                $dataDetail->save();

                $barang = BarangModel::where('id',$value['id'])->decrement('stock',$value['qty']);
            }
            

            $res->code = 200;
            $res->message = "Berhasil Simpan";
            return $res;


        } catch (\Throwable $th) {
            $res->code = 500;
            $res->message = $th->getMessage();
            return $res;
        }
    }
    
}
