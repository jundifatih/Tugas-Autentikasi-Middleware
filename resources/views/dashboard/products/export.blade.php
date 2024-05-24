@php
    $styleHeadMain = 'border: 1px solid black; vertical-align: center; text-align: center; font-weight: 500; font-size: 12px; width: 25px; height: 50px;';
    $styleBodyMain = 'border: 1px solid black;';
@endphp

<table>
    <thead>
        <tr>
            <th style="{{ $styleHeadMain }}">ID</th>
            <th style="{{ $styleHeadMain }}">Nama</th>
            <th style="{{ $styleHeadMain }}">Stok</th>
            <th style="{{ $styleHeadMain }}">Berat</th>
            <th style="{{ $styleHeadMain }}">Harga</th>
            <th style="{{ $styleHeadMain }}">Kondisi</th>
            <th style="{{ $styleHeadMain }}">Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td style="{{ $styleBodyMain }}">{{ $product->id }}</td>
                <td style="{{ $styleBodyMain }}">{{ $product->name }}</td>
                <td style="{{ $styleBodyMain }}">{{ $product->stock }}</td>
                <td style="{{ $styleBodyMain }}">{{ $product->weight }}</td>
                <td style="{{ $styleBodyMain }}">Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                <td style="{{ $styleBodyMain }}">{{ $product->condition }}</td>
                <td style="{{ $styleBodyMain }}">{{ $product->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>