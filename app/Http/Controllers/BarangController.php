<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\PembelianBarangModel;
use App\Models\KategoriModel;
use App\Models\ReturBarangModel;
use Yajra\Datatables\Datatables;
use Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Milon\Barcode\DNS1D;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\LaporanStockExport;
use PDF;
use App\Exports\BarangExcel;
use Session;
class BarangController extends Controller
{
    public function index(Request $req)
    {
        $kategori = KategoriModel::all();
        return view('barang.index',compact('kategori'));
    }

    public function getBarang(Request $req)
    {
        $barang = BarangModel::all();
        // dd($barang);
        return Datatables::of($barang)
                ->addColumn('no_barcode', function ($barang) {
                    $barcode = $barang->no_barcode != null ? $barang->no_barcode : "-";
                    return view('barang.barcode',compact('barcode'));
                })
                ->addColumn('nama_barang', function ($barang) {
                    return $barang->nama_barang != null ? $barang->nama_barang : "-";
                })
                ->addColumn('harga', function ($barang) {
                    $harga = $barang->harga != null ? formatRupiah($barang->harga) : formatRupiah(0);
                    return $harga;
                })
                ->addColumn('stok', function ($barang) {
                    return $barang->stock != null ? formatAngka($barang->stock) : "0";
                })
                ->addColumn('kategori', function ($barang) {
                    return $barang->kategori ? $barang->kategori->nama_kategori : '-';
                })
                ->addColumn('jenis_unit', function ($barang) {
                    return $barang->jenis_unit;
                })
                ->addColumn('status', function ($barang) {
                    if($barang->status == 1){
                        return '<span class="badge badge-primary">Aktif</span>';
                    }else{
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function ($barang) {
                    if($barang->status == 1){
                        if($barang->no_barcode == null){
                            return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$barang->id.'"><i class="far fa-edit"
                                    aria-hidden="true"></i></a><a href="#" class="btn btn-complete m-1 ml-2 btn_view" data-id="'.$barang->id.'"><i class="far fa-eye"
                                    aria-hidden="true"></i></a><a href="#" class="btn btn-danger m-1 btn_delete" data-id="'.$barang->id.'"><i class="fa fa-trash"
                                    aria-hidden="true"></i></a><a href="#" class="btn btn-primary m-1 btn_retur" data-id="'.$barang->id.'"><i class="fas fa-box"></i></a>';
                        }else{
                            return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$barang->id.'"><i class="far fa-edit"
                                    aria-hidden="true"></i></a><a href="#" class="btn btn-complete m-1 ml-2 btn_view" data-id="'.$barang->id.'"><i class="far fa-eye"
                                    aria-hidden="true"></i></a><a href="#" class="btn btn-danger m-1 btn_delete" data-id="'.$barang->id.'"><i class="fa fa-trash"
                                    aria-hidden="true"></i></a><a href="'.route('barang.barcode',['id' => $barang->id]).'" class="btn btn-default m-1 btn_barcode" data-id="'.$barang->id.'"><i class="fa fa-print"
                                    aria-hidden="true"></i></a> <a href="#" class="btn btn-primary m-1 btn_retur" data-id="'.$barang->id.'"><i class="fas fa-box"></i></a>';
                        }
                    }else{
                        return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$barang->id.'"><i class="far fa-edit"
                                aria-hidden="true"></i></a><a href="#" class="btn btn-info m-1 btn_undo" data-id="'.$barang->id.'"><i class="fa fa-undo"
                                aria-hidden="true"></i></a>';
                    }
                })
        ->rawColumns(['barcode','status', 'action'])
        ->make(true);
    }

    public function getBarangAll(Request $request)
    {

        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = BarangModel::where('status' , '1')
                    ->where('nama_barang','LIKE',"%$search%")
                    ->get();
        }else{
            $data = BarangModel::where('status' , '1')
                    ->get();
        }
        return response()->json($data);
    }

    public function historyBarang(Request $request,$id)
    {
        $history = PembelianBarangModel::where('id_barang',$id)->get();
        return Datatables::of($history)
                ->addColumn('harga_beli', function ($history) {
                    return $history->harga != null ? formatRupiah($history->harga) : formatRupiah(0);
                })
                ->addColumn('qty', function ($history) {
                    return $history->qty != null ? formatAngka($history->qty) : formatAngka(0);
                })
                ->addColumn('tgl_beli', function ($history) {
                    return $history->tgl_beli;
                })
                ->addColumn('action', function ($history) {
                    return '<a href="#" class="btn btn-warning m-1 ml-2 btn_editHistory" data-id="'.$history->id.'" data-tgl="'.$history->tgl_beli.'" data-harga="'.$history->harga.'"  data-qty="'.$history->qty.'" ><i class="far fa-edit"
                            aria-hidden="true"></i></a><a href="#" class="btn btn-danger m-1 btn_hapus_history" data-id="'.$history->id.'" ><i class="fa fa-trash"
                            aria-hidden="true"></i></a>';
                })
        ->rawColumns(['status', 'action'])
        ->make(true);

    }

    public function getDetailBarang(Request $req)
    {
        $barang = BarangModel::where('id',$req->id)->first();
        $data = (Object) [];
        if($barang != null) {
            $data->code = 200;
            $data->message = "Success";
            $data->data = $barang;
        }else{
            $data->code = 200;
            $data->message = "Kosong";
            $data->data = $barang;
        }
        return $data;
    }

    public function saveBarang(Request $req)
    {
        $res = (Object)[];
        try {
            $validator = Validator::make($req->all(), [
                'barang' => 'required',
                'harga' => 'required',
                'stok' => 'required',
                'kategori' => 'required',
                'unit' => 'required',
            ]);   

            if($validator->passes()){
                $id = IdGenerator::generate(['table' => 'tbl_barang', 'length' => 5, 'prefix' => 'K']);
                $data = new BarangModel();
                $data->id = $id;
                $data->nama_barang = $req->barang;
                if($req->barcode != null){
                    $data->no_barcode = $req->barcode;
                }
                $data->harga = $req->harga;
                $data->stock = $req->stok;
                $data->kategori_barang = $req->kategori;
                $data->jenis_unit = $req->unit;
                $data->status = 1;
                $data->save();


                $dataPembelian = new PembelianBarangModel();
                $dataPembelian->id_barang = $id;
                $dataPembelian->harga = $req->hargaBeli;
                $dataPembelian->qty = $req->stok;
                $dataPembelian->save();
                

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

    public function updateBarang(Request $request)
    {
        $res = (Object)[];
        try {
            $validator = Validator::make($request->all(), [
                'barang' => 'required',
                'harga' => 'required',
                'stok' => 'required',
                'kategori' => 'required',
                'unit' => 'required',
            ]);   

            if($validator->passes()){
                $update = BarangModel::where('id',$request->id)->update(
                    [
                        'stock' => $request->stok,
                        'nama_barang' => $request->barang,
                        'no_barcode' => $request->barcode,
                        'kategori_barang' => $request->kategori,
                        'jenis_unit' => $request->unit,
                        'harga' => $request->harga,
                    ]
                );
                $res->code = 200;
                $res->message = "Berhasil Update";
            }else{
                $res->code = 200;
                $res->message = "Field Tidak Boleh Kosong";
            }
            return $res;
        }catch(\Thorwable $th){
            $res->code = 500;
            $res->message = $th->getMessage();
            return $res;
        }
    }

    public function deleteBarang(request $request)
    {
        $data = (Object) [];
        try {
            $Barang = BarangModel::where('id',$request->id)->update(['status' => '0']);
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
    public function undoBarang(request $request)
    {
        $data = (Object) [];
        try {
            $Barang = BarangModel::where('id',$request->id)->update(['status' => '1']);
            $data->code = 200;
            $data->message = "Undo Success";
            return $data;
        } catch (\Throwable $th) {
            // throw $th;
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
    }

    public function saveStok(Request $request)
    {
        $data = (Object) [];
        try {
            $validator = Validator::make($request->all(), [
                'idBarang' => 'required',
                'hargaBeli' => 'required',
                'stok' => 'required',
                'date' => 'required',
            ]);
            
            if($validator->passes()){
                $dataPembelian = new PembelianBarangModel();
                $dataPembelian->id_barang = $request->idBarang;
                $dataPembelian->harga = $request->hargaBeli;
                $dataPembelian->qty = $request->stok;
                $dataPembelian->tgl_beli = $request->date;
                $dataPembelian->save();

                $barang = BarangModel::where('id',$request->idBarang)->first();
                if($barang){
                    $stok = $barang->stock + (int) $request->stok;
                    $barang->update(['stock' => $stok]);
                }
            }

            $data->code = 200;
            $data->message = "Berhasil Simpan";
            return $data;
        }catch(\Throwable $th) {
            // throw $th;
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
    }

    public function laporanStock(Request $req)
    {
        $data = (Object) [];
        try {
            $tgl = str_replace(' ', '',$req->tglTanggal);
            $tgl = explode("-",$tgl);
            $from = Carbon::createFromFormat('d/m/Y', $tgl[0])->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', $tgl[1])->format('Y-m-d');
            return Excel::download(new LaporanStockExport($from,$to), 'laporanStock.xlsx');
        } catch (\Throwable $th) {
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
    }

    public function cetakBarcodeBarang(Request $req)
    {
        $barang = BarangModel::where('status','1')->where('id',$req->id)->first();
        $pdf = PDF::loadview('pdf.barcodeBarang',['barang'=>$barang])->setPaper('a4', 'landscape');
        return $pdf->download('barcode_'.$barang->nama_barang.'.pdf');
    }

    public function import_excel(Request $request) 
	{
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
    
            $file = $request->file('file');
            Excel::import(new BarangExcel, $file );
            Session::flash('sukses','Data Barang Berhasil Diimport!');
            return redirect('/barang');
        
	}

    public function returBarang(Request $req)
    {
        $res = (Object) [];
        try {
            $validator = Validator::make($req->all(), [
                'qty' => 'required',
            ]);
            
            if($validator->passes()){
                $barang = BarangModel::where('id',$req->barangID)->first();
                $data = new ReturBarangModel();
                $data->qty = $req->qty;
                $data->id_barang = $req->barangID;
                $data->tgl_retur = date('Y-m-d H:i:s');
                $data->save();
                $barang->update(['stock' => $barang->stock - $req->qty]);

                $res->code = 200;
                $res->message = "Berhasil Simpan";
            }else{
                $res->code = 200;
                $res->message = "Field Tidak Boleh Kosong";
            }
            return $res;
        }catch (\Throwable $th) {
            $res->code = 500;
            $res->message = $th->getMessage();
            return $res;
        }

    }
}
