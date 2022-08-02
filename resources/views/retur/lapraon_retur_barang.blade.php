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
                            <th>Nama Barang</th>
                            <th>Total Retur</th>
                            <th>Tanggal Retur</th>
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
                    action="{{ route('retur.laporan.barang') }}">
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
                        url: "{{ route('retur_barang.list') }}",
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
                            data: 'nama_barang',
                            name: 'Nama Barang'
                        },
                        {
                            data: 'qty',
                            name: 'Total Retur'
                        },
                        {
                            data: 'tgl_retur',
                            name: 'Tanggal Retur'
                        },
                    ]
                });

                $('#search-table').keyup(function() {
                    table.fnFilter($(this).val());
                });
            }

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

        })
    </script>
@endpush
