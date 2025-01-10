<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Models\BranchModel;
use App\Models\StokModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class stockController extends Controller
{
    public function exportPdf($branchId)
{
    $branch = BranchModel::findOrFail($branchId);
    $stocks = StokModel::where('id_cabang', $branchId)->with('produk')->get();

    $pdf = Pdf::loadView('stock.pdf', compact('branch', 'stocks'));
    return $pdf->download('data_stok_' . $branch->alias . '.pdf');
}

    public function exportExcel($branchId)
    {
        return Excel::download(new StockExport($branchId), 'data_stok.xlsx');
    }
}
