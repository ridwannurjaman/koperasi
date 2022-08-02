@extends('layouts.main')

@section('content')
    <div class=" container-fluid   container-fixed-lg bg-white">
        <!-- START card -->
        <div class="card card-transparent">
            <div class="card-header ">
                <div class="card-title">
                    <h3>Simpan Pinjam Detail</h3>
                </div>
                <div class="clearfix"></div>
                <div class="pull-left">
                    <div class="col-xs-12">
                        <h5>Nama Anggota : {{ $simpan->anggota->nama_anggota }}</h5>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
            <div class="card-body">
                <input type="hidden" id="txtHidden" value="{{ $simpan->id }}">
                <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Total</th>
                            <th>Sisa</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
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
    <div class="modal fade" id="modalBayar" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bayar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-bayar" role="form" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Bayar</label>
                                    <input type="text" class="form-control" name="uang"
                                        placeholder="Masukan Jumlah Uang" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-12">
                                <div class="form-group form-group-default"> --}}
                            <input type="hidden" value="{{ $simpan->id }}" name="id">
                            <input type="hidden" name="id_pinjam" id="txtPinjam">
                            {{-- </div>
                            </div> --}}
                        </div>
                        <div class="clearfix">
                        </div>
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
    <div class="modal fade" id="modalView" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bayar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="tableWithSearchDetail">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bayar</th>
                                <th>Tanggal Bayar</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            iniTable();

            function iniTable() {
                var table = $('#tableWithSearch');
                var i = 1;
                var id = $("#txtHidden").val();
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
                        url: "{{ url('simpan-listDetail') }}" + "/" + id,
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
                            data: 'total',
                            name: 'Total'
                        },
                        {
                            data: 'sisa',
                            name: 'Sisa Bayar'
                        },
                        {
                            data: 'jenis',
                            name: 'Jenis'
                        },
                        {
                            data: 'status',
                            name: 'Status'
                        },
                        {
                            data: 'deskripsi',
                            name: 'Deskripsi'
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

            function iniTableDetail(id) {
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
                        url: "{{ url('simpan-bayar-detail') }}" + "/" + id,
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
                            data: 'total',
                            name: 'Total'
                        },
                        {
                            data: 'tanggal',
                            name: 'Tanggal Bayar'
                        },
                    ]
                });

                $('#search-table').keyup(function() {
                    table.fnFilter($(this).val());
                });
            }

            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                var data = $("#form-bayar").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('simpan_pinjam.bayar') }}",
                    data: data,
                    success: function(res) {
                        if (res.code == 200 && res.message == "Berhasil Simpan") {
                            iniTable()
                            $('#modalBayar').modal('toggle');
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

            $(document).on('click', '.btn_bayar', function(e) {
                e.preventDefault();
                $("#modalBayar").modal('show');
                var id = $(this).attr("data-id");
                $("#txtPinjam").val(id)
            })
            $(document).on('click', '.btn_view', function(e) {
                e.preventDefault();
                $("#modalView").modal('show');
                var id = $(this).attr("data-id");
                iniTableDetail(id);
            })
        })
    </script>
@endpush
