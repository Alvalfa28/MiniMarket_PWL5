<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\BranchModel;
use App\Models\DetailTransaksiModel;
use App\Models\ProdukModel;
use App\Models\TransaksiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branchId = auth()->user()->id_cabang;
        $branch = BranchModel::findOrFail($branchId);
        $transactions = TransaksiModel::with('kasir', 'transaksiDetail.produk.kategori')
                                ->where('id_cabang', $branch->id_cabang)
                                ->paginate(10);

        return view('transaksi.index', compact('branch', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branchId = auth()->user()->id_cabang;
    
        $produk = ProdukModel::whereHas('stokProduk', function($query) use ($branchId) {
            $query->where('id_cabang', $branchId);
        })->get();

        return view('transaksi.create', compact('branchId', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id_cabang = Auth::user()->id_cabang;
        
        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'produk' => 'required|array',
            'produk.*.id' => 'required|exists:produk,id',
            'produk.*.jumlah' => 'required|numeric|min:1',
        ]);

        $transaksi = new TransaksiModel();
        $transaksi->id_cabang = $id_cabang;
        $transaksi->tanggal_transaksi = $request->tanggal_transaksi;
        $transaksi->total_harga = 0; 
        $transaksi->kasir_id = Auth::user()->id; 
        $transaksi->save();

        $totalHarga = 0;
        foreach ($request->produk as $produkData) {
            $produk = ProdukModel::findOrFail($produkData['id']);
            $harga = $produk->harga_produk * $produkData['jumlah'];

            $transaksiDetail = new DetailTransaksiModel();
            $transaksiDetail->transaksi_id = $transaksi->id;
            $transaksiDetail->produk_id = $produk->id;
            $transaksiDetail->jumlah = $produkData['jumlah'];
            $transaksiDetail->harga = $harga;
            $transaksiDetail->save();

            $totalHarga += $harga; 
        }

        $transaksi->total_harga = $totalHarga;
        $transaksi->save();

        return redirect()->route('transaksi.create')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportToExcel($branchId)
    {
        return Excel::download(new TransactionsExport($branchId), 'transaksi.xlsx');
    }

    public function exportToPdf($branchId)
    {
        $branch = BranchModel::findOrFail($branchId);
        $transactions = TransaksiModel::with('transaksiDetail.produk.kategori', 'kasir')->get();
        $pdf = Pdf::loadView('transaksi.pdf', compact('transactions', 'branch'));
        
        return $pdf->download('transaksi.pdf');
        
    }
}
