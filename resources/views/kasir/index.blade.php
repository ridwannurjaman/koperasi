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
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                            data-target="#modelId">
                                            Anggota
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm pull-right mr-3"
                                            id="clearAnggota">
                                            Clear Anggota
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-height sm-no-padding">
                                        <p class="small no-margin">Pembayaran untuk</p>
                                        <h5 class="semi-bold m-t-0" id="namaAnggota">-</h5>
                                        <p class="small no-margin">No Anggota</p>
                                        <h5 class="semi-bold m-t-0" id="noAnggota">-</h5>
                                        {{-- <address>
                                            <strong>Pages Incoperated.</strong>
                                            <br>page.inc
                                            <br>
                                            1600 Amphitheatre Pkwy, Mountain View,<br>
                                            CA 94043, United States
                                        </address> --}}
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
                                            <div class="">{{ $id }}</div>
                                            <div class="">{{ $date }}</div>
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
                            <div class="form-group">
                                <label for="">SCAN BARCODE ATAU CARI ITEM </label>
                                <input type="text" class="form-control" name="searchBarang" id="srcBarang"
                                    aria-describedby="helpId" placeholder="Masukan Nama Barang atau No Barcode Barang">
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
                                        <th>Total</th>
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
                                <h5>Subtotal</h5>
                            </div>
                            <div class="pull-right sm-m-t-20">
                                <h5 class="font-montserrat all-caps hint-text" id="subTotal">Rp.0</h5>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        {{-- <div>
                            <div class="form-group form-group-default">
                                <label>Diskon</label>
                                <input type="number" class="form-control" name="diskon" id="txtDiscount"
                                    placeholder="Masukan diskon dalam peresentase" disabled>
                                <small id="helpDiskon" class="form-text text-muted"></small>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div>
                            <div class="form-group form-group-default">
                                <label>Pajak</label>
                                <input type="number" class="form-control" name="pajak" id="txtPajak"
                                    placeholder="Masukan pajak dalam peresentase" disabled>
                                <small id="helpPajak" class="form-text text-muted"></small>
                            </div>
                        </div> --}}
                        <hr>
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
                            <div class="form-group form-group-default">
                                <label>Bayar</label>
                                <input type="text" class="form-control" name="diskon" id="txtBayar"
                                    placeholder="Masukan jumlah uang yang akan dibayar kan" disabled>
                                {{-- <small id="helpDiskon" class="form-text text-muted"></small> --}}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="panelMetodePembayaran">
                            <div class="form-group form-group-default">
                                <label>Metode Pembayaran</label>
                                <select class="full-width form-control" data-placeholder="Pilih Pembayaran"
                                    name="pembayaran" id="metodePembayaran" disabled>
                                    <option value="Cash">Cash</option>
                                    <option value="Kredit">Kredit</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <div class="pull-left">
                                <h5>Kembali</h5>
                            </div>
                            <div class="pull-right sm-m-t-20">
                                <h5 class="font-montserrat all-caps hint-text" id="kembali">Rp.0</h5>
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


    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyContent">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label>Anggota</label>
                                <input type="text" class="form-control" name="nama_lengkap" id="txtAnggota"
                                    placeholder="Masukan Nomor Barcode atau Nama Anggota">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modelEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
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
        var kembali = 0;
        var pajak = 0;
        var diskon = 0;
        var idAnggota = null;
        $(document).ready(function() {
            let arrayBarang = [];

            $("#panelMetodePembayaran").css("display", "none")
            $("#clearAnggota").css("display", "none")

            $("#txtAnggota").autocomplete({
                appendTo: $('#modalBodyContent'),
                source: function(request, response) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('kasir.anggota') }}",
                        dataType: "json",
                        data: {
                            search: request.term,
                            _token: CSRF_TOKEN,
                            barcode: isNaN(request.term) ? 0 : 1
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                var dataAnggota = new Object();
                                dataAnggota.label = item.nama_anggota
                                dataAnggota.value = item.id
                                dataAnggota.id = item.id

                                return dataAnggota;
                            }))

                        },

                    })
                },
                select: function(event, ui) {
                    // addBarang(ui.item)
                    $("#namaAnggota").html(ui.item.label)
                    $("#noAnggota").html(ui.item.id)
                    idAnggota = ui.item.value
                    $('#modelId').modal('toggle');
                    $("#panelMetodePembayaran").css("display", "block")
                    $("#clearAnggota").css("display", "block")
                    return false;
                },
                focus: function(event, ui) {
                    return false;
                },
            })

            $("#srcBarang").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('kasir.searchBarang') }}",
                        dataType: "json",
                        data: {
                            search: request.term,
                            _token: CSRF_TOKEN,
                            barcode: isNaN(request.term) ? 0 : 1
                        },
                        success: function(data) {
                            if (data.length > 1) {
                                response($.map(
                                    data,
                                    function(item) {
                                        var dataBarang = new Object();
                                        dataBarang.label = item.nama_barang +
                                            " | " +
                                            item
                                            .harga + " | " + item.no_barcode +
                                            " | "
                                        dataBarang.value = item.nama_barang
                                        dataBarang.nama_barang = item.nama_barang
                                        dataBarang.harga = item.harga
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
                                            dataBarang.label = item.nama_barang +
                                                " | " +
                                                item
                                                .harga + " | " + item.no_barcode +
                                                " | "
                                            dataBarang.value = item.nama_barang
                                            dataBarang.nama_barang = item
                                                .nama_barang
                                            dataBarang.harga = item.harga
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

            function addBarang(val) {
                var foundIndex = arrayBarang.findIndex(x => x.id == val.id);
                if (foundIndex == -1) {
                    arrayBarang.push({
                        id: val.id,
                        nama_barang: val.nama_barang,
                        harga: val.harga,
                        total_harga: val.harga,
                        qty: 1
                    });
                    $("#tableBarang > tbody").append("<tr id=tr_" + val.id + "><td>" + val.nama_barang +
                        "</td><td>" +
                        formatRupiahText(val.harga) +
                        "</td><td>" + 1 +
                        "</td><td>" + formatRupiahText(val.harga) +
                        "</td><td><button class='btn btn-danger btnDelete' data-id='" +
                        val.id +
                        "'>Delete</button><button class='ml-1 btn btn-complete btnEdit' data-id='" +
                        val.id + "'>Edit</button></td></tr>");
                    // subtotal += val.harga
                    // $("#subTotal").html('Rp.' + formatRupiahText(subtotal))
                } else {
                    arrayBarang[foundIndex].qty += 1
                    arrayBarang[foundIndex].total_harga += val.harga
                    // subtotal += val.harga
                    $('#tr_' + arrayBarang[foundIndex].id).find("td").eq(3).html(formatRupiahText(arrayBarang[
                        foundIndex].total_harga));
                    $('#tr_' + arrayBarang[foundIndex].id).find("td").eq(2).html(arrayBarang[foundIndex].qty);
                    // $("#subTotal").html('Rp.' + formatRupiahText(subtotal))
                }
                $("#srcBarang").val("")
                $("#srcBarang").focus()
                sumTotal()
                fitureDisabled()

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
                fitureDisabled()
            })

            $("#tableBarang").on('click', '.btnEdit', function(e) {
                e.preventDefault();
                $("#modelEdit").modal('toggle');
                var foundIndex = arrayBarang.findIndex(x => x.id === $(this).data('id'));
                if (foundIndex != -1) {
                    $("#editItem").val(arrayBarang[foundIndex].qty);
                    $("#itemId").val(arrayBarang[foundIndex].id);
                }

            })

            $("#btnSubmitEdit").click(function(e) {
                e.preventDefault();
                var foundIndex = arrayBarang.findIndex(x => x.id === $("#itemId").val());
                arrayBarang[foundIndex].qty = $("#editItem").val()
                arrayBarang[foundIndex].total_harga = arrayBarang[foundIndex].harga * $("#editItem").val()
                // subtotal += val.harga
                $('#tr_' + arrayBarang[foundIndex].id).find("td").eq(3).html(formatRupiahText(arrayBarang[
                    foundIndex].total_harga));
                $('#tr_' + arrayBarang[foundIndex].id).find("td").eq(2).html(arrayBarang[foundIndex].qty);
                $("#modelEdit").modal('toggle');
                sumTotal()
            });

            $("#txtDiscount").keyup(function(e) {
                if (arrayBarang.length > 0) {
                    sumTotal()
                }
            });

            $("#txtPajak").keyup(function(e) {
                if (arrayBarang.length > 0) {
                    sumTotal()
                }
            });

            $("#txtBayar").keyup(function(e) {
                if (arrayBarang.length > 0) {
                    sumTotal()
                }
            });

            $("#txtBayar").keyup(function(e) {
                kembali = $("#txtBayar").val() - total;
                $("#kembali").html("Rp." + formatRupiahText(kembali))
                if ($("#metodePembayaran").val() == "Cash") {
                    if (kembali >= 0) {
                        $("#btnSubmitTransaksi").attr('disabled', false)
                    } else {
                        $("#btnSubmitTransaksi").attr('disabled', true)
                    }
                }
            });

            $("#metodePembayaran").change(function(e) {
                e.preventDefault();
                if ($(this).val() == "Kredit") {
                    $("#txtBayar").val(0)
                    $("#btnSubmitTransaksi").attr('disabled', false)
                }
            });


            $("#clearAnggota").click(function(e) {
                idAnggota = null
                $("#namaAnggota").html('-')
                $("#noAnggota").html('-')
                $("#metodePembayaran").val('Cash');
                $("#panelMetodePembayaran").css("display", "none")
                $(this).css('display', 'none')
            })

            $("#btnSubmitTransaksi").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ya',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('kasir.save') }}",

                            data: JSON.stringify({
                                'idAnggota': idAnggota,
                                'dataBarang': arrayBarang,
                                'status_bayar': $("#metodePembayaran").val(),
                                'total': total,
                                'kembali': kembali,
                                'bayar': $("#txtBayar").val(),
                                'pajak': pajak,
                                'diskon': diskon,
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
                var temporarydiskon = 0
                var temporarypajak = 0

                for (let index = 0; index < arrayBarang.length; index++) {
                    subtotal += arrayBarang[index].total_harga;
                }

                // temporarydiskon = $("#txtDiscount").val() != null ? $("#txtDiscount").val() * subtotal / 100 : 0
                // $("#helpDiskon").html('Diskon yang didapat Rp.' + formatRupiahText(temporarydiskon))
                // temporarypajak = $("#txtPajak").val() != null ? $("#txtPajak").val() * subtotal / 100 : 0
                // $("#helpPajak").html('Pajak yang harus dibayar Rp.' + formatRupiahText(temporarypajak))

                temporaryTotal = subtotal
                $("#subTotal").html('Rp.' + formatRupiahText(subtotal))
                $("#total").html('Rp.' + formatRupiahText(temporaryTotal))
                total = temporaryTotal
                pajak = temporarypajak
                diskon = temporarydiskon
            }

            function fitureDisabled() {
                if (arrayBarang.length > 0) {
                    $("#txtBayar").attr('disabled', false)
                    $("#txtPajak").attr('disabled', false)
                    $("#txtDiscount").attr('disabled', false)
                    $("#metodePembayaran").attr('disabled', false)
                } else {
                    $("#txtBayar").attr('disabled', true)
                    $("#txtPajak").attr('disabled', true)
                    $("#txtDiscount").attr('disabled', true)
                    $("#metodePembayaran").attr('disabled', true)
                }
            }
        });
    </script>
@endpush
