<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Stok Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">

    <!-- Wrapper -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="fixed top-0 left-0 w-64 h-full bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 pt-16 px-4">
            <div class="space-y-4">
                @auth
                    @php
                        $branchId = request()->route('branchId');
                    @endphp

                    @hasrole('manager')
                        <a href="{{ route('manager.informasi_cabang') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Informasi Cabang
                        </a>
                    @endhasrole

                    @hasrole('warehouse')
                        <a href="{{ route('stock.index', ['branchId' => $branchId]) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Produk
                        </a>
                    @endhasrole
                @endauth
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64 w-full">
            <!-- Navbar -->
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ route('dashboard') }}">
                                <img src="{{ asset('logo.png') }}" class="h-10 w-auto" alt="Logo">
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <main class="py-6 px-4">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Tambah Stok Produk</h1>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">Isi form di bawah ini untuk menambahkan stok produk baru.</p>
                    <br>
                    <a href="{{ route('stock.index', ['branchId' => $branchId]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">Kembali</a>
                    
                    <form action="{{ route('stock.store', ['branchId' => $branchId]) }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <input type="hidden" name="branchId" value="{{ $branchId }}">
                        <div>
                            <label for="nama_produk" class="block text-sm font-medium text-gray-700 dark:text-gray-200 required">Nama Produk</label>
                            <input type="text" name="nama_produk" id="nama_produk" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                        </div>

                        <div>
                            <label for="id_kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-200 required">Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="jumlah_stok" class="block text-sm font-medium text-gray-700 dark:text-gray-200 required">Jumlah Stok</label>
                            <input type="number" name="jumlah_stok" id="jumlah_stok" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                        </div>

                        <div>
                            <label for="harga_produk" class="block text-sm font-medium text-gray-700 dark:text-gray-200 required">Harga Produk</label>
                            <input type="number" name="harga_produk" id="harga_produk" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                        </div>

                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
