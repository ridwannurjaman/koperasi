<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Barcode Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    @php $noCol = 0; @endphp
    <table>
        @for ($i = 0; $i < 30; $i++)
            @if ($noCol < 2)
                <td>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                            <h5 class="card-title">{{ formatRupiah($barang->harga) }}</h5>
                            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barang->no_barcode, 'C39+') }}"
                                width="250" />
                            {{-- <p>{!! DNS1D::getBarcodeHTML($barang->no_barcode, 'PHARMA2T') !!}</p> --}}
                            <img src="" />
                            <p class="card-text">{{ $barang->no_barcode }}</p>
                        </div>
                    </div>
                </td>
            @else
                <tr></tr>
                <td>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                            <h5 class="card-title">{{ formatRupiah($barang->harga) }}</h5>
                            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barang->no_barcode, 'C39+') }}"
                                width="250" />
                            {{-- <p>{!! DNS1D::getBarcodeHTML($barang->no_barcode, 'PHARMA2T') !!}</p> --}}
                            <p class="card-text">{{ $barang->no_barcode }}</p>
                        </div>
                    </div>
                </td>
            @endif
            @if ($noCol < 2)
                @php
                    $noCol += 1;
                @endphp
            @else
                @php
                    $noCol = 0;
                @endphp
            @endif
        @endfor

    </table>
</body>

</html>
