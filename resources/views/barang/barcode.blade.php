@if ($barcode != '-')
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barcode, 'C39+') }}" width="150" />
    <br>
    <p>{{ $barcode }}</p>
@else
    {{ '-' }}
@endif
