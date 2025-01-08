<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JayusMart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
 
    <!-- Container -->
    <div class="flex justify-center py-10">
        <div class="w-11/12 lg:w-2/3 bg-white dark:bg-gray-800 p-6 rounded-md shadow-md">
            <!-- Title -->

            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
            <h3 class="text-center text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                Data Cabang dan Pengguna
            </h3>

            <!-- Cabang Information -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    {{ $branch->alias }} ({{ $branch->nama_cabang }})
                </h4>
                <p class="text-gray-600 dark:text-gray-400">Telepon: <span class="font-medium">{{ $branch->telepon }}</span></p>
                <p class="text-gray-600 dark:text-gray-400">Alamat: <span class="font-medium">{{ $branch->alamat }}</span></p>
            </div>

            <!-- Table Users -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <thead class="bg-gray-200 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-800 dark:text-gray-300">Nama</th>
                            <th class="px-4 py-2 text-left text-gray-800 dark:text-gray-300">Peran</th>
                            <th class="px-4 py-2 text-left text-gray-800 dark:text-gray-300">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($branch->usersStore as $user)
                            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $user->nama_user }}</td>
                                <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $user->peran }}</td>
                                <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center px-4 py-2 text-gray-500 dark:text-gray-400">Tidak ada pengguna yang terdaftar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
