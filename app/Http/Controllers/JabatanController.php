<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JabatanModel;
use Yajra\Datatables\Datatables;
use Validator;
class JabatanController extends Controller
{
    public function index(Request $req)
    {
        return view('jabatan.index');
    }

    public function getJabatan()
    {
        $jabatan = JabatanModel::all();
        return Datatables::of($jabatan)
                ->addColumn('nama', function ($jabatan) {
                    return $jabatan->jabatan;
                })
                ->addColumn('status', function ($jabatan) {
                    if($jabatan->status == 1){
                        return '<span class="badge badge-primary">Aktif</span>';
                    }else{
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function ($jabatan) {
                    if($jabatan->status == 1){
                        return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$jabatan->id.'" data-jabatan="'.$jabatan->jabatan.'"><i class="far fa-edit"
                                aria-hidden="true"></i></a><a href="#" class="btn btn-danger m-1 btn_delete" data-id="'.$jabatan->id.'"><i class="fa fa-trash"
                                aria-hidden="true"></i></a>';
                    }else{
                        return '<a href="#" class="btn btn-warning m-1 ml-2 btn_edit" data-id="'.$jabatan->id.'" data-jabatan="'.$jabatan->jabatan.'"><i class="far fa-edit"
                                aria-hidden="true"></i></a><a href="#" class="btn btn-info m-1 btn_undo" data-id="'.$jabatan->id.'"><i class="fa fa-undo"
                                aria-hidden="true"></i></a>';
                    }
                    
                })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function saveJabatan(Request $req)
    {
        $res = (Object)[];
        try {
            $validator = Validator::make($req->all(), [
                'jabatan' => 'required',
            ]);    

            if($validator->passes()){
                $data = new JabatanModel();
                $data->jabatan = $req->jabatan;
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

    public function deleteJabatan(request $request)
    {
        $data = (Object) [];
        try {
            $jabatan = JabatanModel::where('id',$request->id)->update(['status' => '0']);
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
    public function undoJabatan(request $request)
    {
        $data = (Object) [];
        try {
            $jabatan = JabatanModel::where('id',$request->id)->update(['status' => '1']);
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

    public function updateJabatan(request $request)
    {
        $data = (Object) [];
        try {
            $jabatan = JabatanModel::where('id',$request->id)->update(['jabatan' => $request->jabatan]);
            $data->code = 200;
            $data->message = "Berhasil Update";
            return $data;
        } catch (\Throwable $th) {
            // throw $th;
            $data->code = 500;
            $data->message = $th->getMessage();
            return $data;
        }
    }
}
