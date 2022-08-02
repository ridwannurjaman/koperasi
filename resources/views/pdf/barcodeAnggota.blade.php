<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Barcode Seluruh Anggota</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    @php $noCol = 0; @endphp
    <table>
        @foreach ($anggota as $item)
            @if ($noCol < 3)
                <td>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama_anggota }}</h5>
                            <h4 class="card-title">{!! DNS1D::getBarcodeHTML($item->id, 'EAN13') !!}</h4>
                            <p class="card-text">{{ $item->id }}</p>
                        </div>
                    </div>
                </td>
            @else
                <tr></tr>
                <td>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama_anggota }}</h5>
                            <h4 class="card-title">{!! DNS1D::getBarcodeHTML($item->id, 'EAN13') !!}</h4>
                            <p class="card-text">{{ $item->id }}</p>
                        </div>
                    </div>
                </td>
            @endif
            @if ($noCol < 3)
                @php
                    $noCol += 1;
                @endphp
            @else
                @php
                    $noCol = 0;
                @endphp
            @endif
        @endforeach

    </table>
</body>

</html>
