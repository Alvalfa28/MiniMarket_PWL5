<!-- Add this to a new edit.blade.php file -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stok Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">

    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 w-1/2">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Stok Produk</h1>
            <form action="{{ route('stock.update', $stock->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mt-4">
                    <label for="id_produk" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pilih Produk</label>
                    <select name="id_produk" id="id_produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-gray-200">
                        @foreach ($produkList as $produk)
                            <option value="{{ $produk->id_produk }}" {{ $produk->id_produk == $stock->id_produk ? 'selected' : '' }}>
                                {{ $produk->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="jumlah_stok" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah Stok</label>
                    <input type="number" name="jumlah_stok" id="jumlah_stok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-gray-200" value="{{ $stock->jumlah_stok }}" required>
                </div>

                <div class="mt-4">
                    <label for="harga_produk" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Harga Produk</label>
                    <input type="number" name="harga_produk" id="harga_produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-gray-200" value="{{ $stock->harga_produk }}" required>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
