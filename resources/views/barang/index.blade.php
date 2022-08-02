@extends('layouts.main')

@section('content')
    <div class=" container-fluid   container-fixed-lg bg-white">
        <!-- START card -->
        <div class="card card-transparent">
            <div class="card-header ">
                <div class="card-title">
                    <h3>Barang</h3>
                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modelImport">Import
                            Barang</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLaporan"><i
                                class="fa fa-plus mr-3"></i>Export Laporan
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId"><i
                                class="fa fa-plus mr-3"></i>Tambah Barang</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalBeliBarang"><i
                                class="fa fa-plus mr-3"></i>Tambah Stok Barang</button>
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
                            <th>No</th>
                            <th>No Barcode</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Stauan</th>
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

    <div class="modal fade" id="modalLaporan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="width:1250px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Laporan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-laporan" role="form" autocomplete="off" method="POST"
                    action="{{ route('barang.laporan') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Tanggal</label>
                                    <input type="text" class="form-control" name="tglTanggal"
                                        placeholder="Masukan Tanggal Transaksi" id="daterangeTransaksi">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnSubmitExport" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang</h5>
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
                                    <label>Nama Barang</label>
                                    <input type="text" class="form-control" name="barang"
                                        placeholder="Masukan Nama Barang" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label>Nomor Barcode</label>
                                    <input type="text" class="form-control" name="barcode"
                                        placeholder="Masukan  Nomor Barcode" id="txtBarcode">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary pull-right" id="generateBarcode">GENERATE
                                    BARCODE</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Harga Jual</label>
                                    <input type="text" class="form-control" name="harga"
                                        placeholder="Masukan Harga Jual" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label>Harga Beli</label>
                                    <input type="text" class="form-control" name="hargaBeli"
                                        placeholder="Masukan Harga Beli">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Stok</label>
                                    <input type="text" class="form-control" name="stok"
                                        placeholder="Masukan Jumlah Stok" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Kategori Barang</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Kategori"
                                        name="kategori">
                                        @foreach ($kategori as $value)
                                            <option value="{{ $value->id }}">{{ $value->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Jenis Unit</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Jenis Unit"
                                        name="unit">
                                        <option value="Pcs">Pieces</option>
                                        <option value="Btl">Botol</option>
                                        <option value="Pkt">Paket</option>
                                        <option value="sct">Sacet</option>
                                        <option value="Bks">Bungkus</option>
                                        <option value="Dus">Dus</option>
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
    <div class="modal fade" id="modalBeliBarang" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-stock" role="form" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Nama Barang</label>
                                    <select class="form-control" name="idBarang" id="barangSelect"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label>Harga Beli</label>
                                    <input type="text" class="form-control" name="hargaBeli"
                                        placeholder="Masukan Harga Beli">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Stok</label>
                                    <input type="text" class="form-control" name="stok"
                                        placeholder="Masukan Jumlah Stok" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Tanggal Beli</label>
                                    <input type="date" class="form-control" name="date"
                                        placeholder="Masukan Tanggal Beli" required>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmitStok" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalReturBarang" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Retur Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-retur" role="form" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Jumlah Retur</label>
                                    <input type="text" class="form-control" name="qty"
                                        placeholder="Masukan Jumlah Barang yang akan di retur" required>
                                    <input type="hidden" name="barangID" id="txtIDBarang">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmitRetur" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-personal-edit" role="form" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Nama Barang</label>
                                    <input type="text" class="form-control" id="eBarang" name="barang"
                                        placeholder="Masukan Nama Barang" required>
                                    <input type="hidden" name="id" id="txtHidden">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label>Nomor Barcode</label>
                                    <input type="text" class="form-control" id="eBarcode" name="barcode"
                                        placeholder="Masukan  Nomor Barcode">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Harga Jual</label>
                                    <input type="text" class="form-control" name="harga" id="editHarga"
                                        placeholder="Masukan Harga Jual" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Stok</label>
                                    <input type="text" class="form-control" id="eStok" name="stok"
                                        placeholder="Masukan Jumlah Stok" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Kategori Barang</label>
                                    <select class="full-width form-control" id="editKategori"
                                        data-placeholder="Pilih Kategori" name="kategori">
                                        @foreach ($kategori as $value)
                                            <option value="{{ $value->id }}">{{ $value->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Jenis Unit</label>
                                    <select class="full-width form-control" id="editJenisUnit"
                                        data-placeholder="Pilih Jenis Unit" name="unit">
                                        <option value="Pcs">Pieces</option>
                                        <option value="Btl">Botol</option>
                                        <option value="Pkt">Paket</option>
                                        <option value="Sct">Sacet</option>
                                        <option value="Bks">Bungkus</option>
                                        <option value="Dus">Dus</option>
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

    <!-- Modal -->
    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width:1250px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View History Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="panelTable">
                            <table class="table table-striped" id="tableWithSearchDetail">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Harga Beli</th>
                                        <th>Qty</th>
                                        <th>Tanggal Beli</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4" id="panelEdit">
                            <form id="form-personal-editStok" role="form" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default">
                                            <label>Harga Beli</label>
                                            <input type="text" class="form-control" id="historyHarga"
                                                name="hargaBeli" placeholder="Masukan Harga Beli">
                                            <input type="hidden" name="id" id="historyId">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default required">
                                            <label>Stok</label>
                                            <input type="text" class="form-control" id="historyStok" name="stok"
                                                placeholder="Masukan Jumlah Stok" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-default required">
                                            <label>Tanggal Beli</label>
                                            <input type="date" class="form-control" id="historyTgl" name="date"
                                                placeholder="Masukan Tanggal Beli" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <h5 class="modal-title">Import Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-import" role="form" autocomplete="off"
                    method="POST"action="{{ route('barang.importExcel') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>File Barang</label>
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
@endsection


@push('script')
    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            iniTable()

            function iniTableView(id) {
                var table = $('#tableWithSearchDetail');
                var i = 1;
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
                        url: "{{ url('barang-history') }}" + "/" + id,
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
                            "render": function() {
                                return i++;
                            }
                        },
                        {
                            data: 'harga_beli',
                            name: 'Harga Beli'
                        },
                        {
                            data: 'qty',
                            name: 'Qty'
                        },
                        {
                            data: 'tgl_beli',
                            name: 'Tanggal Beli'
                        },
                    ]
                });

                $('#search-table').keyup(function() {
                    table.fnFilter($(this).val());
                });
            }

            function iniTable() {
                var table = $('#tableWithSearch');
                var i = 1;
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
                        url: "{{ route('barang.list') }}",
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
                            "render": function() {
                                return i++;
                            }
                        }, {
                            data: 'no_barcode',
                            name: 'No Barcode'
                        },
                        {
                            data: 'nama_barang',
                            name: 'Nama Barang'
                        },
                        {
                            data: 'harga',
                            name: 'Harga Jual'
                        },
                        {
                            data: 'stok',
                            name: 'Stok'
                        },
                        {
                            data: 'kategori',
                            name: 'Kategori'
                        },
                        {
                            data: 'jenis_unit',
                            name: 'Satuan'
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

            $("#btnSubmitEdit").click(function(e) {
                e.preventDefault();
                var data = $("#form-personal-edit").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('barang.update') }}",
                    data: data,
                    success: function(res) {
                        if (res.code == 200 && res.message == "Berhasil Update") {
                            iniTable()
                            $('#modalEdit').modal('toggle');
                            Swal.fire(
                                'Success!',
                                'Berhasil menyimpan data',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Opps!',
                                res.message,
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
            $("#btnSubmitRetur").click(function(e) {
                e.preventDefault();
                var data = $("#form-retur").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('barang.returBarang') }}",
                    data: data,
                    success: function(res) {
                        if (res.code == 200 && res.message == "Berhasil Simpan") {
                            iniTable()
                            $('#modalEdit').modal('toggle');
                            Swal.fire(
                                'Success!',
                                'Berhasil menyimpan data',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Opps!',
                                res.message,
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

            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                var data = $("#form-personal").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('barang.save') }}",
                    data: data,
                    success: function(res) {
                        if (res.code == 200 && res.message == "Berhasil Simpan") {
                            iniTable()
                            $('#modelId').modal('toggle');
                            Swal.fire(
                                'Success!',
                                'Berhasil menyimpan data',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Opps!',
                                res.message,
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
            $("#btnSubmitStok").click(function(e) {
                e.preventDefault();
                var data = $("#form-stock").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('barang.saveStock') }}",
                    data: data,
                    success: function(res) {
                        if (res.code == 200 && res.message == "Berhasil Simpan") {
                            iniTable()
                            $('#modalBeliBarang').modal('toggle');
                            Swal.fire(
                                'Success!',
                                'Berhasil menyimpan data',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Opps!',
                                res.message,
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
                $.ajax({
                    type: "GET",
                    url: "{{ url('barang-detail') }}" + '/' + id,
                    success: function(response) {
                        if (response.code == 200 && response.message == "Success") {
                            $("#eBarang").val(response.data.nama_barang);
                            $("#eStok").val(response.data.stock);
                            $("#eBarcode").val(response.data.no_barcode);
                            $("#editKategori").val(response.data.kategori_barang);
                            $("#editJenisUnit").val(response.data.jenis_unit);
                            $("#editHarga").val(response.data.harga);
                            $("#txtHidden").val(id);
                        } else {
                            Swal.fire('Error!', '', 'error')
                        }
                    }
                });
            })

            $(document).on('click', '.btn_view', function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                iniTableView(id)
                $("#modalView").modal('show');
                $("#panelEdit").css("display", "none");
            })

            $(document).on('click', '.btn_retur', function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                iniTableView(id)
                $("#modalReturBarang").modal('show');
                $("#txtIDBarang").val(id);
            })

            // $(document).on('click', '.btn_editHistory', function(e) {
            //     $("#panelEdit").css("display", "block");
            //     $("#panelTable").removeClass("col-md-12");
            //     $("#panelTable").addClass("col-md-8");
            //     var harga = $(this).attr("data-harga");
            //     var tgl = $(this).attr("data-tgl");
            //     var id = $(this).attr("data-id");
            //     var qty = $(this).attr("data-qty");

            //     $("#historyStok").val(qty)
            //     $("#historyHarga").val(harga)
            //     $("#historyTgl").val(tgl)
            //     $("#historyId").val(id)
            // })

            $(document).on('click', '.btn_delete', function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Apakah anda yakin akan menghapus barang ini?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ya',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('barang.delete') }}",
                            data: {
                                'id': id,
                                '_token': CSRF_TOKEN
                            },
                            success: function(response) {
                                console.log(response.code)
                                if (response.code == 200 && response.message ==
                                    "Delete Success") {
                                    Swal.fire('Non-aktif!', '', 'success')
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
            $(document).on('click', '.btn_undo', function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Apakah anda yakin akan mengundo barang ini?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ya',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('barang.undo') }}",
                            data: {
                                'id': id,
                                '_token': CSRF_TOKEN
                            },
                            success: function(response) {
                                console.log(response.code)
                                if (response.code == 200 && response.message ==
                                    "Undo Success") {
                                    Swal.fire('Berhasil!', '', 'success')
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

            $('#barangSelect').select2({
                width: '100%',
                placeholder: 'Pilih item',
                ajax: {
                    url: '{{ route('barang.search') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_barang,
                                    id: item.id,
                                    val: item.id
                                }
                            })
                        };
                    },
                },
                cache: true
            });

            $("#generateBarcode").click(function(e) {
                e.preventDefault();
                $("#txtBarcode").val(Math.floor(Math.random() * 1000000000))
            })

            var start = moment().subtract(29, 'days');
            var end = moment();

            $('#daterangeTransaksi').daterangepicker({
                autoUpdateInput: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            });


            $("#daterangeTransaksi").on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
            });
        });
    </script>
@endpush
