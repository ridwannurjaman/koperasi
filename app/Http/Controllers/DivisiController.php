<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DivisiModel;
use Yajra\Datatables\Datatables;
use Validator;
class DivisiController extends Controller
{
    public function index(Request $req)
    {
        return view('divisi.index');
    }

    public function getDivisi()
    {
        $divisi = DivisiModel::all();
        return Datatables::of($divisi)
                ->addColumn('nama', function ($divisi) {
                    return $divisi->nama_divisi;
                })
                ->addColumn('status', function ($divisi) {
                    if($divisi->status == 1){
                        return '<span class="badge badge-primary">Aktif</span>';
                    }else{
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function ($divisi) {
                    if($divisi->status == 1){
                        return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$divisi->id.'" data-divisi="'.$divisi->nama_divisi.'"><i class="far fa-edit"
                                aria-hidden="true"></i></a><a href="#" class="btn btn-danger m-1 btn_delete" data-id="'.$divisi->id.'"><i class="fa fa-trash"
                                aria-hidden="true"></i></a>';
                    }else{
                        return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$divisi->id.'" data-divisi="'.$divisi->nama_divisi.'"><i class="far fa-edit"
                                aria-hidden="true"></i></a><a href="#" class="btn btn-info m-1 btn_undo" data-id="'.$divisi->id.'"><i class="fa fa-undo"
                                aria-hidden="true"></i></a>';
                    }
                    
                })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function saveDivisi(Request $req)
    {
        $res = (Object)[];
        try {
            $validator = Validator::make($req->all(), [
                'divisi' => 'required',
            ]);    

            if($validator->passes()){
                $data = new DivisiModel();
                $data->nama_divisi = $req->divisi;
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

    public function deleteDivisi(request $request)
    {
        $data = (Object) [];
        try {
            $jabatan = DivisiModel::where('id',$request->id)->update(['status' => '0']);
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
    public function undoDivisi(request $request)
    {
        $data = (Object) [];
        try {
            $jabatan = DivisiModel::where('id',$request->id)->update(['status' => '1']);
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

    public function updateDivisi(request $request)
    {
        $data = (Object) [];
        try {
            $validator = Validator::make($request->all(), [
                'divisi' => 'required',
            ]);  

            if($validator->passes()){
                $jabatan = DivisiModel::where('id',$request->id)->update(['nama_divisi' => $request->divisi]);
                $data->code = 200;
                $data->message = "Berhasil Update";
                return $data;
            }else{
                $data->code = 200;
                $data->message = "Inputan Tidak Boleh Kosong!";
                return $data;
            }
        } catch (\Throwable $th) {
            // throw $th;
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
    }
}
