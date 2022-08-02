@extends('layouts.main')

@section('content')
    <div class=" container-fluid   container-fixed-lg bg-white">
        <!-- START card -->
        <div class="card card-transparent">
            <div class="card-header ">
                <div class="card-title">
                    <h3>Jabatan</h3>
                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId"><i
                                class="fa fa-plus mr-3"></i>Tambah Jabatan</button>
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
                            <th>Nama Jabatan</th>
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
                    <h5 class="modal-title">Tambah Jabatan</h5>
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
                                    <label>Nama Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan"
                                        placeholder="Masukan Nama Jabatan" required>
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
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jabatan</h5>
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
                                    <label>Nama Jabatan</label>
                                    <input type="text" id="editJabatan" class="form-control" name="jabatan"
                                        placeholder="Masukan Nama Jabatan" required>
                                    <input type="hidden" name="id" id="txthidden">
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
                        url: "{{ route('jabatan.list') }}",
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
                            data: 'nama',
                            name: 'Nama Jabatan'
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

            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                var data = $("#form-personal").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('jabatan.save') }}",
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

            $("#btnSubmitEdit").click(function(e) {
                e.preventDefault();
                var data = $("#form-personal-edit").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('jabatan.update') }}",
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
                var jabatan = $(this).attr("data-jabatan");
                var id = $(this).attr("data-id");
                $("#editJabatan").val(jabatan)
                $("#txthidden").val(id)
            })


            $(document).on('click', '.btn_delete', function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Apakah anda yakin akan menghapus jabatan ini?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ya',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('jabatan.delete') }}",
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
                    title: 'Apakah anda yakin akan mengundo jabatan ini?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ya',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('jabatan.undo') }}",
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
        });
    </script>
@endpush
