<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Barcode Seluruh Anggota</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $anggota->nama_anggota }}</h5>
                <h4 class="card-title">{!! DNS1D::getBarcodeHTML($anggota->id, 'EAN13') !!}</h4>
                <p class="card-text">{{ $anggota->id }}</p>
            </div>
        </div>
    </div>
</body>

</html>
