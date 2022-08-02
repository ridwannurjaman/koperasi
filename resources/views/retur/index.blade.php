@extends('layouts.main')

@section('content')
    <div class="container-fluid-lg p-3">
        <div class="row">

            <div class="col-12 mr-3">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-9 col-sm-height sm-no-padding">
                                        <p class="small no-margin">Retur dari</p>
                                        <h5 class="semi-bold m-t-0" id="namaAnggota">-</h5>
                                        <p class="small no-margin">No Anggota</p>
                                        <h5 class="semi-bold m-t-0" id="noAnggota">-</h5>
                                    </div>
                                    <div
                                        class="col-lg-3 sm-no-padding sm-p-b-20 d-flex align-items-end justify-content-between">

                                        <div>
                                            <div class="font-montserrat bold all-caps">Transaksi No :
                                            </div>
                                            <div class="font-montserrat bold all-caps">Tanggal Transaksi :</div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="text-right">
                                            <div class="" id="noTransaksi"></div>
                                            <div class="" id="tglTransaksi"></div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="row ">
                    <div class="card">
                        <div class="card-body">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" id="labelSwitch" for="customSwitch1">Transaksi</label>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="" id="labelSearch">CARI TRANSAKSI</label>
                                <input type="text" class="form-control" name="searchBarang" id="srcBarang"
                                    aria-describedby="helpId" placeholder="Masukan Nomor Transaksi">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-inverse" id="tableBarang">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Item</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-default">
                    <div class="card-body">
                        <div>
                            <div class="pull-left">
                                <h5>Total</h5>
                            </div>
                            <div class="pull-right sm-m-t-20">
                                <h5 class="font-montserrat all-caps hint-text" id="total">Rp.0</h5>
                            </div>
                            {{-- <small id="helpDiskon" class="form-text text-muted"></small> --}}
                            {{-- <div class="clearfix"></div> --}}
                        </div>
                        <hr>
                        <div>
                            <div class="pull-right sm-m-t-20">
                                <button type="button" class="btn btn-primary" id="btnSubmitTransaksi"
                                    disabled>Submit</button>
                            </div>
                            {{-- <div class="clearfix"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <div class="modal fade" id="modelEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyContent">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label>Qty</label>
                                <input type="text" class="form-control" name="nama_lengkap" id="editItem"
                                    placeholder="">
                                <input type="hidden" name="idItem" id="itemId">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitEdit">submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .ui-autocomplete {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            text-align: left;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
        }

        .ui-autocomplete>li>div {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333333;
            white-space: nowrap;
        }

        .ui-state-hover,
        .ui-state-active,
        .ui-state-focus {
            text-decoration: none;
            color: #262626;
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .ui-helper-hidden-accessible {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
    </style>
@endpush
@push('script')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var total = 0;
        var idTransaksi = null;
        $(document).ready(function() {
            let arrayBarang = [];
            $("#srcBarang").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('retur.returItem') }}",
                        dataType: "json",
                        data: {
                            search: request.term,
                            _token: CSRF_TOKEN,
                            switch: $("#customSwitch1").is(':checked')
                        },
                        success: function(data) {
                            if (data.length > 1) {
                                response($.map(
                                    data,
                                    function(item) {
                                        var dataBarang = new Object();
                                        dataBarang.label = "Nama Anggota : " + item
                                            .nama_anggota +
                                            " | Tanggal Transaksi : " +
                                            item
                                            .tgl_transaksi + " | Total : " + item
                                            .total_transaksi +
                                            " | "
                                        dataBarang.value = item.barang
                                        dataBarang.nama_anggota = item.nama_anggota
                                        dataBarang.tgl_transaksi = item
                                            .tgl_transaksi
                                        dataBarang.id_anggota = item
                                            .id_anggota
                                        dataBarang.id = item.id
                                        return dataBarang;
                                    }
                                ));
                            } else {
                                if (!isNaN(request.term)) {
                                    addBarang(data[0])
                                    $("#srcBarang").val("");
                                    $("#srcBarang").focus();
                                    return false;
                                } else {
                                    response($.map(
                                        data,
                                        function(item) {
                                            var dataBarang = new Object();
                                            dataBarang.label = "Nama Anggota : " +
                                                item
                                                .nama_anggota +
                                                " | Tanggal Transaksi : " +
                                                item
                                                .tgl_transaksi + " | Total : " +
                                                item
                                                .total_transaksi +
                                                " | "
                                            dataBarang.value = item.barang
                                            dataBarang.nama_anggota = item
                                                .nama_anggota
                                            dataBarang.tgl_transaksi = item
                                                .tgl_transaksi
                                            dataBarang.id_anggota = item
                                                .id_anggota
                                            dataBarang.id = item.id
                                            return dataBarang;
                                        }
                                    ));
                                }
                            }
                        },

                    });
                },
                select: function(event, ui) {
                    addBarang(ui.item)
                    return false;
                },
                focus: function(event, ui) {
                    return false;
                },
            });

            $("#customSwitch1").change(function(e) {
                e.preventDefault();
                if ($(this).is(':checked')) {
                    $(this).is(':checked');
                    $("#labelSwitch").html('Anggota')
                    $("#labelSearch").html('CARI ANGGOTA')
                    $("#srcBarang").attr('placeholder', 'Masukan Nama Anggota')
                } else {
                    $(this).is(':checked');
                    $("#labelSwitch").html('Transaksi')
                    $("#labelSearch").html('CARI TRANSAKSI')
                    $("#srcBarang").attr('placeholder', 'Masukan Nomor Transaksi')
                }
            });

            function addBarang(barang) {
                arrayBarang = [];
                $("#namaAnggota").html(barang.nama_anggota)
                $("#noAnggota").html(barang.id_anggota)
                $("#noTransaksi").html(barang.id)
                $("#tglTransaksi").html(barang.tgl_transaksi)
                idTransaksi = barang.id;
                $("#tableBarang > tbody").html("");
                for (let index = 0; index < barang.value.length; index++) {
                    arrayBarang.push({
                        id: barang.value[index].id,
                        id_barang: barang.value[index].id_barang,
                        nama_barang: barang.value[index].nama_barang,
                        harga: barang.value[index].harga,
                        total_harga: barang.value[index].total_peritem,
                        qty: barang.value[index].qty
                    });
                    $("#tableBarang > tbody").append("<tr id=tr_" + barang.value[index].id + "><td>" + barang.value[
                            index].nama_barang +
                        "</td><td>" +
                        formatRupiahText(barang.value[index].harga) +
                        "</td><td>" + formatRupiahText(barang.value[index].qty) +
                        "</td><td>" + formatRupiahText(barang.value[index].total_peritem) +
                        "</td><td><button class='btn btn-danger btnDelete' data-id='" +
                        barang.value[index].id +
                        "'>Delete</button><button class='ml-1 btn btn-complete btnEdit' data-id='" +
                        barang.value[index].id + "'>Edit</button></td></tr>");
                }
                $("#srcBarang").val("")
                $("#srcBarang").focus()
                sumTotal()

            }

            function formatRupiahText(angka) {
                var number_string = angka.toString(),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            $("#tableBarang").on('click', '.btnDelete', function(e) {
                e.preventDefault();
                arrayBarang.splice(arrayBarang.findIndex(item => item.id === $(this).data('id')), 1)
                $(this).closest("tr").remove();
                if (arrayBarang.length > 0) {
                    $("#txtBayar").attr('disabled', false)
                } else {
                    $("#txtBayar").attr('disabled', true)
                }
                sumTotal()
            })

            $("#tableBarang").on('click', '.btnEdit', function(e) {
                e.preventDefault();
                $("#modelEdit").modal('toggle');
                var foundIndex = arrayBarang.findIndex(x => x.id === $(this).data('id'));
                if (foundIndex != -1) {
                    $("#editItem").val(arrayBarang[foundIndex].qty);
                    $("#itemId").val($(this).data('id'));
                }
            })

            $("#btnSubmitEdit").click(function(e) {
                e.preventDefault();
                var foundIndex = arrayBarang.findIndex(x => x.id == $("#itemId").val());
                arrayBarang[foundIndex].qty = $("#editItem").val()
                arrayBarang[foundIndex].total_harga = arrayBarang[foundIndex].harga * $("#editItem").val()
                $('#tr_' + arrayBarang[foundIndex].id).find("td").eq(3).html(formatRupiahText(arrayBarang[
                    foundIndex].total_harga));
                $('#tr_' + arrayBarang[foundIndex].id).find("td").eq(2).html(arrayBarang[foundIndex].qty);
                $("#modelEdit").modal('toggle');
                sumTotal()
            });

            $("#btnSubmitTransaksi").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin ingin meretur pada transaksi ini?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ya',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('retur.save') }}",

                            data: JSON.stringify({
                                'idTransaksi': idTransaksi,
                                'dataBarang': arrayBarang,
                                'total': total,
                                '_token': CSRF_TOKEN
                            }),
                            contentType: "application/json",
                            dataType: "json",
                            success: function(response) {
                                if (response.code == 200 && response.message ==
                                    "Berhasil Simpan") {
                                    Swal.fire(
                                        'Success!',
                                        'Berhasil menyimpan data',
                                        'success'
                                    );
                                    location.reload();
                                } else {
                                    Swal.fire(
                                        'Opps!',
                                        response.message,
                                        'error'
                                    );
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Batal Melakukan Transaksi', '', 'info')
                    }
                })
            })

            function sumTotal() {
                var subtotal = 0
                var temporaryTotal = 0
                temporaryTotal = subtotal
                for (let index = 0; index < arrayBarang.length; index++) {
                    subtotal += arrayBarang[index].total_harga;
                }
                temporaryTotal = subtotal
                $("#subTotal").html('Rp.' + formatRupiahText(subtotal))
                $("#total").html('Rp.' + formatRupiahText(temporaryTotal))
                total = temporaryTotal
                $("#btnSubmitTransaksi").attr('disabled', false)
            }
        });
    </script>
@endpush
