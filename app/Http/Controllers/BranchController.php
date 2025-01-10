<?php

namespace App\Http\Controllers;

use App\Models\BranchModel;
use App\Models\StokModel;
use App\Models\TransaksiModel;
use App\Models\UserStore;
use Illuminate\Http\Request;
// use App\Models\ProdukModel;

class BranchController extends Controller
{
    public function getBranch()
    {
        $branches = BranchModel::all(); 
        $branchId = auth()->user()->branch_id ?? 1;
        return view('dashboard', compact('branches'));
    }

    public function index(Request $request)
    {
        return view('dashboard');
    }

    public function dashboardOwner(Request $request)
    {
        $branches = BranchModel::all();

        $branch = null;
        $totalProduk = 0;
        $totalPenjualan = 0;

        if ($request->has('id_cabang')) {
            $branch = BranchModel::find($request->id_cabang);

            if ($branch) {
                $totalProduk = StokModel::where('id_cabang', $branch->id_cabang)->count();
                $totalPenjualan = TransaksiModel::where('id_cabang', $branch->id_cabang)->sum('total_harga');
            }
        }

        $role = 'owner';
        return view('dashboard', compact('branches', 'branch', 'totalProduk', 'totalPenjualan'));
    }

    public function dashboard($branchId = null)
    {
        $branchId = $branchId ?? auth()->user()->branch_id ?? 1;
        $branch = BranchModel::findOrFail($branchId);

        if (!auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized access');
        }

        return view('owner.dashboard', compact('branch')); 
    }

    public function dashboardRole(Request $request)
    {
        $userRole = auth()->user()->peran; 
        $branchId = auth()->user()->id_cabang; 
        $branch = BranchModel::where('id_cabang', $branchId)->first();
        // dd($userRole);
        // dd($branchId);
        $view = match ($userRole) {
            'manager' => 'dashboard.manager',
            'supervisor' => 'dashboard.supervisor',
            'cashier' => 'dashboard.cashier',
            'warehouse' => 'dashboard.warehouse',
        };
        // dd($view); 
        return view($view,  compact('userRole', 'branch'));
    }

        public function showStock($branchId)
    {
        $branch = BranchModel::findOrFail($branchId);
        $stocks = StokModel::with(['produk.kategori'])
                    ->where('id_cabang', $branchId)
                    ->paginate(10);

        return view('stock.index', compact('branch', 'stocks'));
    }

    public function redirectDashboard()
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'User not authenticated.');
        }

        $role = strtolower($user->peran ?? '');

        switch ($role) {
            case 'owner':
                return redirect()->route('dashboard.owner'); 
            case 'manager':
                return redirect()->route('dashboard.manager'); 
            case 'supervisor':
                return redirect()->route('dashboard.supervisor'); 
            case 'cashier':
                return redirect()->route('dashboard.cashier'); 
            case 'warehouse':
                return redirect()->route('dashboard.warehouse'); 
            default:
                abort(403, 'Unauthorized role.');
        }
    }


    public function showTransaction($branchId)
    {
        $branch = BranchModel::findOrFail($branchId);
        $transactions = TransaksiModel::with('kasir', 'transaksiDetail.produk.kategori')
                                ->where('id_cabang', $branch->id_cabang)
                                ->paginate(10);

        return view('transaksi.index', compact('branch', 'transactions'));
    }

    public function informationBranch()
    {
        $branches = BranchModel::with('usersStore')->get();
        return view('owner.informasi', compact('branches'));
    }

    public function informationBranchRole()
    {
        $userRole = auth()->user()->peran; 
        $branchId = auth()->user()->id_cabang; 
        $branch = BranchModel::with('usersStore')->where('id_cabang', $branchId)->first();
    
        if (!$branch) {
            abort(404, 'Cabang tidak ditemukan.');
        }
    
        return view('dashboard.informasiUser', compact('branch'));
    }
}
