@extends('layouts.main')

@section('content')
    <div class=" container-fluid   container-fixed-lg bg-white">
        <!-- START card -->
        <div class="card card-transparent">
            <div class="card-header ">
                <div class="card-title">
                    <h3>Laporan Retur</h3>
                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLaporan"><i
                                class="fa fa-plus mr-3"></i>Export Retur</button>
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
                            <th>Nomor Transaksi</th>
                            <th>Nama Anggota</th>
                            <th>Tanggal Transaksi</th>
                            <th>Tanggal Retur</th>
                            <th>Total Retur</th>
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
                    <h5 class="modal-title">Laporan Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-laporan" role="form" autocomplete="off" method="POST"
                    action="{{ route('retur.laporan') }}">
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


    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width:1250px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View History Retur Barang</h5>
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
                                        <th>ID Retur</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
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
                        url: "{{ route('retur.list') }}",
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
                            data: 'id',
                            name: 'No Transaksi'
                        },
                        {
                            data: 'nama_anggota',
                            name: 'Nama Anggota'
                        },
                        {
                            data: 'tgl_transaksi',
                            name: 'Tanggal Transaksi'
                        },
                        {
                            data: 'tgl_retur',
                            name: 'Tanggal Retur'
                        },
                        {
                            data: 'total',
                            name: 'Total'
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
                        url: "{{ url('retur-list') }}" + "/" + id,
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
                            data: 'id',
                            name: 'ID Retur'
                        },
                        {
                            data: 'nama_barang',
                            name: 'Nama Barang'
                        },
                        {
                            data: 'qty',
                            name: 'Qty'
                        },
                        {
                            data: 'total_peritem',
                            name: 'Total item'
                        },
                    ]
                });

                $('#search-table').keyup(function() {
                    table.fnFilter($(this).val());
                });
            }

            $(document).on('click', '.btn_view', function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                iniTableView(id)
                $("#modalView").modal('show');
                $("#panelEdit").css("display", "none");

            })

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#daterangeTransaksi span').html(start.format('DD/MM/YYYY') + ' - ' + end.format(
                    'DD/MM/YYYY'));
            }
            cb(start, end);

            $('#daterangeTransaksi').daterangepicker({
                startDate: start,
                endDate: end,
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


            // $("#btnSubmitExport").click(function(e) {
            //     e.preventDefault();
            //     var data = $("#form-laporan").serialize();
            //     $.ajax({
            //         type: "POST",
            //         url: "{{ route('transaksi.laporan') }}",
            //         data: data,
            //         success: function(result, status, xhr) {
            //             $('#modalLaporan').modal('toggle');
            //             if (status == "success") {
            //                 let blob = new Blob([result], {
            //                     type: "application/vnd.ms-excel"
            //                 });
            //                 let link = URL.createObjectURL(blob);
            //                 let a = document.createElement("a");
            //                 a.download = "file.xlsx";
            //                 a.href = link;
            //                 document.body.appendChild(a);
            //                 a.click();
            //                 document.body.removeChild(a);
            //             }
            //         },
            //         error: function(msg) {
            //             Swal.fire(
            //                 'Opps!',
            //                 msg,
            //                 'error'
            //             );
            //         }
            //     });
            // })
        })
    </script>
@endpush
