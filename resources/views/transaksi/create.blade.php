<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
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
                    @hasrole('owner|manager|supervisor|warehouse')
                        <a href="{{ route('stock.index', ['branchId' => $branchId]) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Produk
                        </a>
                    @endhasrole
                    @hasrole('cashier')
                        <a href="{{ route('transaksi.create', ['branchId' => $branchId]) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Penjualan
                        </a>
                    @endhasrole
                    @hasrole('owner|manager|supervisor')
                        <a href="{{ route('transaksi.index', ['branchId' => $branchId]) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Transaksi
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

                        <!-- Profile Dropdown -->
                        <div class="flex items-center">
                            <div class="relative">
                                <button onclick="toggleDropdown()" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none">
                                    <span>{{ Auth::user()->nama_user }}</span>
                                    <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2">
                                        @csrf
                                        <button type="submit" class="w-full text-left text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Log Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <main class="py-6 px-4">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="mb-8">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">                           
                        Kembali
                    </a>
                </div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Tambah Transaksi </h1>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">Form untuk menambah transaksi baru </p>
                    
                    <form action="{{ route('transaksi.store') }}" method="POST" class="mt-6">
                        @csrf
                        <div class="space-y-4">
                            <!-- Kasir -->
                            <div>
                                <label for="kasir" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kasir</label>
                                <select id="kasir" name="kasir_id" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-gray-200">
                                    <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->nama_user }}</option>
                                </select>
                            </div>

                            <div>
                                <label for="produk" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Produk</label>
                                <select id="produk" name="produk_id" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-gray-200">
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah</label>
                                <input type="number" id="jumlah" name="jumlah" min="1" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-gray-200" required>
                            </div>

                            <div>
                                <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Transaksi</label>
                                <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-gray-200" required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
