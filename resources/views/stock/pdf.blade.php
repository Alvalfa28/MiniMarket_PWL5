<!-- resources/views/stok/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stok Produk - {{ $branch->alias }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 12px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Stok Produk di Cabang {{ $branch->alias }}</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Jumlah Stok</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $index => $stock)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $stock->produk->nama_produk }}</td>
                    <td>{{ $stock->produk->kategori->nama_kategori ?? 'Kategori tidak tersedia' }}</td>
                    <td>{{ $stock->jumlah_stok }}</td>
                    <td>Rp {{ number_format($stock->produk->harga_produk, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
