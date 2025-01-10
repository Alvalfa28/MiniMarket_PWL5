<?php

namespace App\Http\Controllers;

use App\Models\BranchModel;
use App\Models\StokModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use App\Models\ProdukModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        // return view('stock.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id_cabang;
        $produk = new ProdukModel();
        $kategori = $request->id_kategori;
        if($kategori == 'Makanan'){
            $cate = 'food';
        }
        if($kategori == 'Minuman'){
            $cate = 'drink';
        }
        $stok = new StokModel();
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $cate;
        $produk->harga_produk = $request->harga_produk;
        $produk->save();
        $stok->id_produk = $produk->id;
        $stok->id_cabang = $id;
        $stok->nama_produk = $request->nama_produk;
        $stok->jumlah_stok = $request->jumlah_stok;
        $stok->last_updated = Carbon::now();
        
        $stok->save();
    
        return redirect()->route('stock.index')
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
    public function edit($branchId, $stockId)
    {
        $stok = StokModel::with('produk')->where('id_cabang', $branchId)->findOrFail($stockId);
        $categories = CategoryModel::all(); 
        return view('stock.edit', compact('stok', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $branchId, $stockId)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric',
            'jumlah_stok' => 'required|numeric',
            'id_kategori' => 'required|string',
        ]);
    
        $stok = StokModel::with('produk')->where('id_cabang', $branchId)->findOrFail($stockId);
        $produk = $stok->produk; 
    
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->harga_produk = $request->harga_produk;
        $produk->save();
    
        $stok->jumlah_stok = $request->jumlah_stok;
        $stok->last_updated = Carbon::now();
        $stok->save();
    
        return redirect()->route('stock.index')
            ->with('success', 'Stok produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($branchId, $stockId)
    {
        $stok = StokModel::where('id_cabang', $branchId)->findOrFail($stockId);
        $produk = $stok->produk; 

        $stok->delete();
        $produk->delete();

        return redirect()->route('stock.index')
            ->with('success', 'Stok produk berhasil dihapus.');
    }
}
