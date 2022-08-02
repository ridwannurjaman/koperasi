@extends('layouts.main')

@section('content')
    <div class=" container-fluid   container-fixed-lg bg-white">
        <!-- START card -->
        <div class="card card-transparent">
            <div class="card-header ">
                <div class="card-title">
                    <h3>Anggota Koperasi</h3>
                    {{-- notifikasi form validasi --}}
                    @if ($errors->has('file'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('file') }}</strong>
                        </span>
                    @endif

                    {{-- notifikasi sukses --}}
                    @if ($sukses = Session::get('sukses'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $sukses }}</strong>
                        </div>
                    @elseif($sukses = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $sukses }}</strong>
                        </div>
                    @endif
                </div>
                <div class="pull-right">
                    <div class="col-xs-6">
                        <a href="{{ route('anggota.cetakBarcode') }}" class="btn btn-success">Download PDF
                            Barcode
                            Anggota</a>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modelImport">Import
                            Anggota</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId">Tambah
                            Anggota</button>
                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId"><i
                                class="fa fa-plus"></i>Tambah Anggota</button> --}}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="tableWithSearch">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>ID Anggota</th>
                            <th>Divisi</th>
                            <th>Jabatan</th>
                            <th>No Hp</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END card -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-personal" role="form" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap"
                                        placeholder="Masukan Nama Lengkap" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Jenis Kelamin</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Jenis Kelamin"
                                        name="jk">
                                        <option value="Laki - Laki">Laki - Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" placeholder="Masukan Alamat" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>No Hp</label>
                                    <input type="number" class="form-control" name="no_hp" placeholder="Masukan No HP"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Divisi</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Divisi" name="divisi">
                                        @foreach ($divisi as $value)
                                            <option value="{{ $value->id }}">{{ $value->nama_divisi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Jabatan</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Jabatan" name="jabatan">
                                        @foreach ($jabatan as $value)
                                            <option value="{{ $value->id }}">{{ $value->jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modelImport" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-import" role="form" autocomplete="off"
                    method="POST"action="{{ route('anggota.import') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>File Anggota</label>
                                    <input type="file" class="form-control" name="file"
                                        placeholder="Masukan Nama Lengkap" required>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnSubmit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modelBarcode" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Barcode Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="barcodeContent">
                        <div id="barcodeImg"></div>
                        <p id="noBarcode"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnPrintBarcode" data-id="1" class="btn btn-primary">Print</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-personal-edit" role="form" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id" id="txtHidden">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap"
                                        placeholder="Masukan Nama Lengkap" id="editNama" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Jenis Kelamin</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Jenis Kelamin"
                                        name="jk" id="editJk">
                                        <option value="" selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki - Laki">Laki - Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" placeholder="Masukan Alamat" id="editAlamat" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>No Hp</label>
                                    <input type="number" class="form-control" name="no_hp" id="editNoHp"
                                        placeholder="Masukan No HP" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Divisi</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Divisi"
                                        name="divisi" id="ediitDivisi">
                                        @foreach ($divisi as $value)
                                            <option value="{{ $value->id }}">{{ $value->nama_divisi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Jabatan</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Jabatan"
                                        name="jabatan" id="editJabatan">
                                        @foreach ($jabatan as $value)
                                            <option value="{{ $value->id }}">{{ $value->jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Status</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Status"
                                        name="status" id="selectStatus">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmitEdit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            iniTable()

            function iniTable() {
                var table = $('#tableWithSearch');
                var settings = {
                    "sDom": "<t><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ ",
                        "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
                    },
                    "iDisplayLength": 25,
                };

                table.dataTable({
                    sDom: "<t><'row'<p i>>",
                    destroy: true,
                    scrollCollapse: true,
                    oLanguage: {
                        sLengthMenu: "_MENU_ ",
                        sInfo: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
                    },
                    iDisplayLength: 25,
                    ajax: {
                        url: "{{ route('anggota.list') }}",
                        type: "post",
                        dataType: 'json',
                        data: function(params) {
                            return {
                                _token: CSRF_TOKEN
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    },
                    columns: [{
                            data: 'nama',
                            name: 'Nama Anggota'
                        },
                        {
                            data: 'id',
                            name: 'ID ANGGOTA'
                        },
                        {
                            data: 'divisi',
                            name: 'Divisi'
                        },
                        {
                            data: 'jabatan',
                            name: 'Jabatan'
                        },
                        {
                            data: 'no_hp',
                            name: 'No Hp'
                        },
                        {
                            data: 'status',
                            name: 'Status'
                        },
                        {
                            data: 'action',
                            name: 'Aksi'
                        },
                    ]
                });

                $('#search-table').keyup(function() {
                    table.fnFilter($(this).val());
                });
            }

            $("#btnPrintBarcode").click(function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                window.location.href = '{{ url('/anggota-barcode/') }}' + '/' + id
            })

            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                var data = $("#form-personal").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('anggota.save') }}",
                    data: data,
                    success: function(msg) {
                        iniTable()
                        $('#modelId').modal('toggle');
                        if (msg == "success") {
                            Swal.fire(
                                'Success!',
                                'Berhasil menyimpan data',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Opps!',
                                msg,
                                'error'
                            );
                        }
                    },
                    error: function(msg) {
                        Swal.fire(
                            'Opps!',
                            msg,
                            'error'
                        );
                    }
                });
            });

            $("#btnSubmitEdit").click(function(e) {
                e.preventDefault();
                var data = $("#form-personal-edit").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('anggota.update') }}",
                    data: data,
                    success: function(msg) {
                        iniTable()
                        $('#modalEdit').modal('toggle');
                        if (msg.message == "Berhasil Update" && msg.code == 200) {
                            Swal.fire(
                                'Success!',
                                'Berhasil menyimpan data',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Opps!',
                                msg.message,
                                'error'
                            );
                        }
                    },
                    error: function(msg) {
                        Swal.fire(
                            'Opps!',
                            msg,
                            'error'
                        );
                    }
                });
            });

            $(document).on('click', '.btn_edit', function(e) {
                e.preventDefault();
                $("#modalEdit").modal('show');
                var id = $(this).attr("data-id");


                // var jk = "";
                $.ajax({
                    type: "GET",
                    url: "{{ url('anggota') }}" + '/' + id,
                    success: function(response) {
                        if (response.code == 200) {
                            $("#editNama").val(response.data.nama_anggota);
                            $("#editAlamat").val(response.data.alamat);
                            $("#editNoHp").val(response.data.no_hp);
                            $("#editJk").val(response.data.jk);
                            $("#selectJabatan").val(response.data.id_jabatan);
                            $("#selectDivisi").val(response.data.id_divisi);
                            $("#selectStatus").val(response.data.status);
                            $("#txtHidden").val(id);
                        } else {
                            Swal.fire('Error!', '', 'error')
                        }
                    }
                });
            })

            $(document).on('click', '.btn_view', function(e) {
                e.preventDefault();
                $("#modelBarcode").modal('show');
                var id = $(this).attr("data-id");
                $("#btnPrintBarcode").attr("data-id", id);
                $.ajax({
                    type: "GET",
                    url: "{{ url('anggota') }}" + '/' + id,
                    success: function(response) {
                        if (response.code == 200) {
                            $("#barcodeImg").html(response.barcode)
                            $("#noBarcode").html(response.data.id)
                        }
                    }
                })
                // $("#barcodeContent").html(javaScriptVar)

            })
            $(document).on('click', '.btn_delete', function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Apakah anda yakin akan menghapus anggota ini?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ya',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('anggota.delete') }}",
                            data: {
                                'id': id,
                                '_token': CSRF_TOKEN
                            },
                            success: function(response) {
                                console.log(response.code)
                                if (response.code == 200 && response.message ==
                                    "Delete Success") {
                                    Swal.fire('Saved!', '', 'success')
                                    iniTable();
                                } else {
                                    Swal.fire('Error!', '', 'error')
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Batal Melakukan Delete', '', 'info')
                    }
                })

            });
        });
    </script>
@endpush
