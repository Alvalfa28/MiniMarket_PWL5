<?php

namespace App\Http\Controllers;

use App\Models\BranchModel;
use App\Models\StokModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use App\Models\ProdukModel;
use Carbon\Carbon;

class produkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user()->id_cabang;
        $branch = BranchModel::findOrFail($user);
        $stocks = StokModel::with(['produk.kategori'])
                    ->where('id_cabang', $user)
                    ->paginate(10);

        return view('stock.index', compact('branch', 'stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branchId = auth()->user()->id_cabang;
        $categories = CategoryModel::all(); 
    
        return view('stock.create', compact('branchId', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:categories,id',
            'harga_produk' => 'required|numeric|min:0',
            'jumlah_stok' => 'required|integer|min:1',
        ]);
    
        \Log::debug('Validated Data:', $validatedData);
        
        $branchId = auth()->user()->id_cabang;
    
        $produk = ProdukModel::create([
            'nama_produk' => $validatedData['nama_produk'],
            'id_kategori' => $validatedData['id_kategori'],
            'harga_produk' => $validatedData['harga_produk'],
        ]);
    
        $stok = StokModel::create([
            'id_produk' => $produk->id,
            'id_cabang' => $branchId,
            'nama_produk' => $validatedData['nama_produk'],
            'jumlah_stok' => $validatedData['jumlah_stok'],
            'last_updated' => Carbon::now(),
        ]);
    
        \Log::debug('Produk Saved:', $produk->toArray());
        \Log::debug('Stok Saved:', $stok->toArray());
    
        return redirect()->route('stock.index', ['branchId' => $branchId])
            ->with('success', 'Stok produk berhasil ditambahkan.');
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
}
