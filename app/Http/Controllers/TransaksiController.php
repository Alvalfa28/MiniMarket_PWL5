<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\BranchModel;
use App\Models\TransaksiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
