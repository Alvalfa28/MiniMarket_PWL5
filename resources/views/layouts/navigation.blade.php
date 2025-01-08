<nav x-data="{ open: false, reportOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex ml-64">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- <h2 class="margin font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Dashboard') }}
                    </h2> -->
                    <x-nav-link :href="route('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Search Bar and Dropdown -->
            @auth
            @if (Auth::user()->hasRole('owner'))
            <div class="flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white dark:text-gray-100 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>View Branch</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    
                            <x-slot name="content">
                                <!-- <x-dropdown-link :href="route('dashboard')" :class="(request()->routeIs('dashboard')) ? 'bg-slate-600' : ''">
                                    Pusat
                                </x-dropdown-link> -->
                                @foreach ($branches as $branch)
                                    @if ($branch->alias !== 'Pusat') 
                                        <x-dropdown-link :href="route('owner.dashboard', ['branchId' => $branch->id_cabang])" :class="(request()->route('branchId') === $branch->id_cabang) ? 'bg-slate-600 font-bold' : ''">
                                            {{ $branch->alias }}
                                        </x-dropdown-link>
                                    @endif
                                @endforeach
                            </x-slot>
                        @endif
                    @endauth
                </x-dropdown>
            </div>

            <!-- User Profile Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nama_user }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="fixed top-0 left-0 w-64 h-full bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 pt-16 px-4">
        <div class="space-y-1">
            @auth
                @php
                    $branchId = request()->route('branchId');
                @endphp
                @if (!$branchId)
                    @hasrole('owner|manager')
                        <x-responsive-nav-link href="{{ route('owner.informasi') }}">
                            Informasi Cabang
                        </x-responsive-nav-link>
                    @endhasrole
                @endif
                @if ($branchId)
                    @hasrole('cashier')
                        <x-responsive-nav-link href="#">Penjualan</x-responsive-nav-link>
                    @endhasrole

                    @hasrole('owner|manager|supervisor|warehouse')
                    <x-responsive-nav-link :href="route('stock.show', ['branchId' => $branchId])">
                        Produk
                    </x-responsive-nav-link>
                    @endhasrole

                    @hasrole('owner|manager|supervisor|warehouse|cashier')
                    <x-responsive-nav-link href="{{ route('transaction.show', ['branchId' => request()->route('branchId')]) }}">
                        Transaksi
                    </x-responsive-nav-link>
                    @endhasrole

                    <!-- @hasrole('owner|manager|supervisor')
                        <button @click="reportOpen = !reportOpen" class="w-full text-left text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                            Unduh Laporan
                        </button>
                        <div :class="{ 'block': reportOpen, 'hidden': !reportOpen }" class="hidden ml-4">
                            <x-responsive-nav-link href="#">Transaksi</x-responsive-nav-link>
                            <x-responsive-nav-link href="#">Stok</x-responsive-nav-link>
                        </div>
                    @endhasrole -->
                @endif
            @endauth
        </div>
    </div>
</nav>
