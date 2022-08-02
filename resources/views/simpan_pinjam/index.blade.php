@extends('layouts.main')

@section('content')
    <div class=" container-fluid   container-fixed-lg bg-white">
        <!-- START card -->
        <div class="card card-transparent">
            <div class="card-header ">
                <div class="card-title">
                    <h3>Simpan Pinjam</h3>
                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                                class="fa fa-plus mr-3"></i>Tambah</button>
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
                <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Total Debit</th>
                            <th>Total Kredit</th>
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
    <div class="modal fade" id="modalTambah" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-simpan" role="form" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Nama Anggota</label>
                                    <select class="form-control" name="nama_anggota" id="anggotaSelect"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label>Uang Simpan / Pinjam</label>
                                    <input type="text" class="form-control" name="uang"
                                        placeholder="Masukan jumlah uang">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Jenis</label>
                                    <select class="full-width form-control" data-placeholder="Pilih Jenis" name="jenis">
                                        <option value="kredit">Kredit</option>
                                        <option value="debit">Debit</option>
                                    </select>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" name="deskripsi"
                                        placeholder="Masukan Deskripsi">
                                </div>
                            </div>
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
@endsection

@push('script')
    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            iniTable();

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
                        url: "{{ route('simpan_pinjam.list') }}",
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
                            data: 'nama_anggota',
                            name: 'Nama Anggota'
                        },
                        {
                            data: 'total_debit',
                            name: 'Total Debit'
                        },
                        {
                            data: 'total_kredit',
                            name: 'Total Kredit'
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

            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                var data = $("#form-simpan").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('simpan_pinjam.save') }}",
                    data: data,
                    success: function(res) {
                        if (res.code == 200 && res.message == "Berhasil Simpan") {
                            iniTable()
                            $('#modalTambah').modal('toggle');
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

            $('#anggotaSelect').select2({
                width: '100%',
                placeholder: 'Pilih item',
                ajax: {
                    url: '{{ route('anggota.search') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_anggota,
                                    id: item.id,
                                    val: item.id
                                }
                            })
                        };
                    },
                },
                cache: true
            });
        })
    </script>
@endpush
