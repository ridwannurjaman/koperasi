<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Yajra\Datatables\Datatables;
use Validator;
class KategoriController extends Controller
{
    public function index(Request $req)
    {
        return view('kategori.index');
    }

    public function getKategori()
    {
        $kategori = KategoriModel::all();
        return Datatables::of($kategori)
                ->addColumn('nama', function ($kategori) {
                    return $kategori->nama_kategori;
                })
                ->addColumn('status', function ($kategori) {
                    if($kategori->status == 1){
                        return '<span class="badge badge-primary">Aktif</span>';
                    }else{
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function ($kategori) {
                    if($kategori->status == 1){
                        return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$kategori->id.'" data-Kategori="'.$kategori->nama_kategori.'"><i class="far fa-edit"
                                aria-hidden="true"></i></a><a href="#" class="btn btn-danger m-1 btn_delete" data-id="'.$kategori->id.'"><i class="fa fa-trash"
                                aria-hidden="true"></i></a>';
                    }else{
                        return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$kategori->id.'" data-jabatan="'.$kategori->nama_kategori.'"><i class="far fa-edit"
                                aria-hidden="true"></i></a><a href="#" class="btn btn-info m-1 btn_undo" data-id="'.$kategori->id.'"><i class="fa fa-undo"
                                aria-hidden="true"></i></a>';
                    }
                    
                })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function saveKategori(Request $req)
    {
        $res = (Object)[];
        try {
            $validator = Validator::make($req->all(), [
                'kategori' => 'required',
            ]);    

            if($validator->passes()){
                $data = new KategoriModel();
                $data->nama_kategori = $req->kategori;
                $data->status = 1;
                $data->save();
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

    public function deleteKategori(request $request)
    {
        $data = (Object) [];
        try {
            $kategori = KategoriModel::where('id',$request->id)->update(['status' => '0']);
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
    public function undoKategori(request $request)
    {
        $data = (Object) [];
        try {
            $kategori = KategoriModel::where('id',$request->id)->update(['status' => '1']);
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

    public function updateKategori(request $request)
    {
        $data = (Object) [];
        try {
            $validator = Validator::make($request->all(), [
                'kategori' => 'required',
            ]);    

            if($validator->passes()){
                $kategori = KategoriModel::where('id',$request->id)->update(['nama_kategori' => $request->kategori]);
                $data->code = 200;
                $data->message = "Berhasil Update";
            }else{
                $data->code = 200;
                $data->message = "Inputan tidak boleh kosong";
            }
            return $data;
        } catch (\Throwable $th) {
            // throw $th;
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
    }
}
