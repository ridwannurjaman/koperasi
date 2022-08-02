<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JabatanModel;
use App\Models\DivisiModel;
use App\Models\AnggotaModel;
use Yajra\Datatables\Datatables;
use Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Milon\Barcode\DNS1D;
use App\Exports\AnggotaExcel;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use PDF;
use Storage;
use ZipArchive;
use File;
class AnggotaController extends Controller
{
    public function index(Request $req)
    {
        $jabatan = JabatanModel::where('status','1')->get();
        $divisi = DivisiModel::where('status','1')->get();
        return view('anggota.index',compact('jabatan','divisi'));
    }

    public function getAnggota(Request $req)
    {
        $anggota = AnggotaModel::all();
        return Datatables::of($anggota)
        ->addColumn('nama', function ($anggota) {
            return $anggota->nama_anggota;
        })
        ->addColumn('id', function ($anggota) {
            return $anggota->id;
        })
        ->addColumn('divisi', function ($anggota) {
            return $anggota->divisi->nama_divisi;
        })
        ->addColumn('jabatan', function ($anggota) {
            return $anggota->jabatan->jabatan;
        })
        ->addColumn('alamat', function ($anggota) {
            return $anggota->alamat;
        })
        ->addColumn('no_hp', function ($anggota) {
            return '0'.$anggota->no_hp;
        })
        ->addColumn('status', function ($anggota) {
            if($anggota->status == "Aktif"){
                return '<span class="badge badge-primary">Aktif</span>';
            }else{
                return '<span class="badge badge-danger">Tidak Aktif</span>';
            }
        })
        ->addColumn('action', function ($anggota) {
            return view('anggota.component.actionTable', compact('anggota'));
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function getAnggotaDetail($id){
        $d = new DNS1D();
        $d->setStorPath(__DIR__.'/cache/');
        
        $anggota = AnggotaModel::where('id',$id)->first();
        $data = (Object) [];
        if($anggota != null){
            $data->code = 200;
            $data->message = "Get Data Success";
            $data->barcode =  $d->getBarcodeHTML($anggota->id, 'EAN13');
            $data->data = $anggota;
        }else{
            $data->code = 200;
            $data->message = "Anggota tidak ditemuka";
            $data->data = $anggota;
        }

        return $data;
    }

    public function searchAnggota(Request $req)
    {
        $data = [];
        if($req->has('q')){
            $search = $req->q;
            $data = AnggotaModel::where('status' , 'Aktif')
                    ->where('nama_anggota','LIKE',"%$search%")
                    ->get();
        }else{
            $data = AnggotaModel::where('status' , 'Tidak Aktif')
                    ->get();
        }
        return response()->json($data);
    }

    public function deleteAnggota(request $request)
    {
        $data = (Object) [];
        try {
            $anggota = AnggotaModel::where('id',$request->id)->update(['status'=>'Tidak Aktif']);
            $data->code = 200;
            $data->message = "Delete Success";
            return $data;
        } catch (\Throwable $th) {
            // throw $th;
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
    }

    public function saveAnggota(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'nama_lengkap' => 'required',
                'jk' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
                'divisi' => 'required',
                'jabatan' => 'required',
            ]);

            if($validator->passes()){
                $id = IdGenerator::generate(['table' => 'tbl_anggota','length' => 8, 'prefix' => date('my')]);
                $data = new AnggotaModel();
                $data->id = $id ;
                $data->nama_anggota = $req->nama_lengkap;
                $data->jk = $req->jk;
                $data->alamat = $req->alamat;
                $data->no_hp = $req->no_hp;
                $data->id_divisi = $req->divisi;
                $data->id_jabatan = $req->jabatan;
                $data->status = "Aktif";
                $data->save();
                return "success";
                
            }else{
                return "Inputan Harus Diisi.";
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function updateAnggota(Request $req)
    {
        $data = (Object)[];
        try {
            $validator = Validator::make($req->all(), [
                'nama_lengkap' => 'required',
                'jk' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
                'divisi' => 'required',
                'jabatan' => 'required',
            ]);
            if($validator->passes()){
                AnggotaModel::where('id',$req->id)->update([
                    'nama_anggota' => $req->nama_lengkap,
                    'jk' => $req->jk,
                    'alamat' => $req->alamat,
                    'no_hp' => $req->no_hp,
                    'id_divisi' => $req->divisi,
                    'id_jabatan' => $req->jabatan,
                    'status' => $req->status,
                ]);
                $data->code = 200;
                $data->message = "Berhasil Update";
                return $data;
            }else{
                $data->code = 200;
                $data->message = "Inputan Tidak Boleh Kosong!";
                return $data;
            }
        } catch (\Throwable $th) {
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
    }

    public function import_excel(Request $request) 
	{
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
    
            $file = $request->file('file');
            Excel::import(new AnggotaExcel, $file );
            Session::flash('sukses','Data Anggota Berhasil Diimport!');
            return redirect('/anggota');
        } catch (\Throwable $th) {
            // throw $th;
            Session::flash('error','Anggota gagal Diimport!');
            return redirect('/anggota');
        }
        
	}

    public function cetakBarcode(Request $req)
    {
        try {
            $zip = new ZipArchive; 
            $anggota = AnggotaModel::where('status','Aktif')->get()->chunk(100);
            $count = count($anggota);
            for ($i=0; $i < $count ; $i++) { 
                $pdf = PDF::loadview('pdf.barcodeAnggota',['anggota'=>$anggota[$i],'count'=>$count])->setPaper('a4', 'landscape');
                Storage::disk('public')->put('pdf/anggota-barcode-'.$i.'.pdf', $pdf->output());
            }

            $filename = "anggota-barcode.zip";
            if($zip->open(public_path($filename),ZipArchive::CREATE) == TRUE){
                $files = File::files(public_path('storage/pdf'));
                    foreach ($files as $key => $value){
                        $relativeName = basename($value);
                        $zip->addFile($value, $relativeName);
                    }
                $zip->close();
            }
            return response()->download(public_path($filename));   
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cetakBarcodeAnggota(Request $req)
    {
        $anggota = AnggotaModel::where('status','Aktif')->where('id',$req->id)->first();
        $pdf = PDF::loadview('pdf.barcodeAnggotaOnly',['anggota'=>$anggota])->setPaper('a4', 'landscape');
        return $pdf->download('barcode_'.$anggota->nama_anggota.'.pdf');
    }
}
