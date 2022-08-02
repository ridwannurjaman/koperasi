<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimpanPinjamModel;
use App\Models\SimpanPinjamDetailModel;
use App\Models\BayarDetailModel;
use Yajra\Datatables\Datatables;
use Validator;
class SimpanPinjamController extends Controller
{
    public function index()
    {
        return view('simpan_pinjam.index');
    }

    public function detail($id)
    {
        $simpan = SimpanPinjamModel::where('id',$id)->first();
        return view('simpan_pinjam.detail',compact('simpan'));
    }

    public function list(Request $req)
    {
        $anggota = SimpanPinjamModel::all();
        return Datatables::of($anggota)
        ->addColumn('nama_anggota', function ($anggota) {
            return $anggota->anggota->nama_anggota;
        })
        ->addColumn('total_debit', function ($anggota) {
            return formatRupiah($anggota->total_debit);
        })
        ->addColumn('total_kredit', function ($anggota) {
            return formatRupiah($anggota->total_kredit);
        })
        ->addColumn('action', function ($anggota) {
            $url = route('simpan_pinjam.detail',['id' => $anggota->id]);
            return '<a href="'. $url .'" class="btn btn-complete m-1 ml-2 btn_view" data-id="'.$anggota->id.'"><i class="far fa-eye"
            aria-hidden="true"></i></a>';
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function listDetail($id)
    {
        $simpan = SimpanPinjamDetailModel::where('id_pinjam',$id)->get();
        return Datatables::of($simpan)
        ->addColumn('total', function ($simpan) {
            return formatRupiah($simpan->total);
        })
        ->addColumn('sisa', function ($simpan) {
            return formatRupiah($simpan->sisa);
        })
        ->addColumn('jenis', function ($simpan) {
            return $simpan->jenis;
        })
        ->addColumn('deskripsi', function ($simpan) {
            return $simpan->deskripsi;
        })
        ->addColumn('status', function ($simpan) {
            return $simpan->jenis != 'debit' ? $simpan->status : '-';
        })
        ->addColumn('action', function ($simpan) {
            if($simpan->jenis == "kredit" && $simpan->status == "Belum Lunas"){
                return '<a href="#" class="btn btn-success m-1 ml-2 btn_bayar" data-id="'.$simpan->id.'"><i class="fa-solid fa-money-bill"></i></a><a href="#" class="btn btn-complete m-1 ml-2 btn_view" data-id="'.$simpan->id.'"><i class="far fa-eye"
                aria-hidden="true"></i></a>';
            }else if($simpan->jenis == "kredit" && $simpan->status == "Lunas" && $simpan->sisa == 0){
                return '<a href="#" class="btn btn-complete m-1 ml-2 btn_view" data-id="'.$simpan->id.'"><i class="far fa-eye"
                aria-hidden="true"></i></a>';
            }
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function bayarDetail($id)
    {
        $simpan = BayarDetailModel::where('id_detail_pinjam',$id)->get();
        return Datatables::of($simpan)
        ->addColumn('total', function ($simpan) {
            return formatRupiah($simpan->bayar);
        })
        ->addColumn('tanggal', function ($simpan) {
            return $simpan->created_at;
        })
        ->make(true);
    }
    

    public function save(Request $req)
    {
        $res = (Object)[];
        try {
            $validator = Validator::make($req->all(), [
                'nama_anggota' => 'required',
                'uang' => 'required',
                'jenis' => 'required',
                'date' => 'required',
            ]);   

            if($validator->passes()){
                $cekData = SimpanPinjamModel::where('id_anggota',$req->nama_anggota)->first();
                if($cekData != null){
                    $id = $cekData->id;
                    if($req->jenis == "debit"){
                        $data = SimpanPinjamModel::where('id',$cekData->id)->update([
                            'total_debit' => $cekData->total_debit+$req->uang ,
                        ]);
                    }else{
                        $data = SimpanPinjamModel::where('id',$cekData->id)->update([
                            'total_kredit'=>$cekData->total_kredit+$req->uang ,
                        ]);
                    }
                }else{
                    $data = new SimpanPinjamModel();
                    $data->id_anggota = $req->nama_anggota;
                    if($req->jenis == "debit"){
                        $data->total_debit = $req->uang;
                        $data->total_kredit = 0;
                    }else{
                        $data->total_kredit = $req->uang;
                        $data->total_debit = 0;
                    }
                    $data->save();
                    $id = $data->id;
                    
                }

                $dataDetail = new SimpanPinjamDetailModel();
                $dataDetail->tanggal = date('Y-m-d H:i:s');
                $dataDetail->jenis = $req->jenis;
                $dataDetail->id_pinjam = $id;
                $dataDetail->total = $req->uang;
                $dataDetail->deskripsi = $req->deskripsi;
                if($req->jenis == "kredit"){
                    $dataDetail->status = "Belum Lunas";
                    $dataDetail->sisa = $req->uang;
                }else{
                    $dataDetail->sisa = 0;
                }
                $dataDetail->save();
                $res->code = 200;
                $res->message = "Berhasil Simpan";
                return $res;
            }else{
                $res->code = 200;
                $res->message = "Inputan Tidak Boleh Kosong!";
                return $res;
            }
        }catch(\Thorwable $th){
            $res->code = 500;
            $res->message = $th->getMessage();
            return $res;
        }
    }

    public function bayar(Request $req)
    {   
        $res = (Object)[];
        try {

            $validator = Validator::make($req->all(), [
                'uang' => 'required',
            ]);   
            if($validator->passes()){
                $cekData = SimpanPinjamModel::where('id',$req->id)->first();
                $cekDataPinjam = SimpanPinjamDetailModel::where('id',$req->id_pinjam)->first();
                $data = new BayarDetailModel();
                $data->bayar = $req->uang;
                $data->id_detail_pinjam = $req->id_pinjam;
                $data->save();
                $sisa  = $req->uang > $cekDataPinjam->total ? $cekDataPinjam->sisa - $cekDataPinjam->sisa : $cekDataPinjam->sisa  - $req->uang;;
                if($sisa == 0){
                    SimpanPinjamDetailModel::where('id',$req->id_pinjam)->update(['sisa' => $sisa,'status' => 'Lunas']);
                }else{
                    SimpanPinjamDetailModel::where('id',$req->id_pinjam)->update(['sisa' => $sisa]);
                }
                SimpanPinjamModel::where('id',$req->id)->update(['total_kredit' => $cekData->total_kredit - $req->uang]);
                $res->code = 200;
                $res->message = "Berhasil Simpan";
                return $res;

            }else{
                $res->code = 200;
                $res->message = "Inputan Tidak Boleh Kosong!";
                return $res;
            }
        }catch(\Thorwable $th){
            $res->code = 500;
            $res->message = $th->getMessage();
            return $res;
    }
    }
}
