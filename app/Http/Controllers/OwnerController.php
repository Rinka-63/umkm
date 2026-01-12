<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        $total_barang = Barang::count();
        $total_supplier = Supplier::count();
        $rusak = Barang::where('stok', '<=', 5)->count();
        $baik = Barang::where('stok', '>', 5)->count();
        $grafik = Barang::orderBy('stok', 'desc')->take(5)->get();

        $data_barang = Barang::latest()->get();
        $data_supplier = Supplier::latest()->get();

        $barangs = Barang::where('stok', '>', 0)->get();
        $transaksis = PenjualanDetail::with('barang','penjualan')
                  ->orderBy('created_at', 'desc')
                  ->get();

        $suppliers = \App\Models\Supplier::withCount('barangs')->get();
    
        // Mengambil data barang berdasarkan filter supplier jika ada
        $supplierId = request('supplier_id');
        $data_barang = \App\Models\Barang::when($supplierId, function($query) use ($supplierId) {
            return $query->where('supplier_id', $supplierId);
        })->get();

        $from = $request->from;
        $to = $request->to;

        // 2. Hitung Total Volume Terjual
        $total_terjual = PenjualanDetail::when($from && $to, function($query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
            })
            ->sum('qty');

        return view('dashboard.owner', compact(
            'total_barang','total_supplier','rusak','baik',
            'grafik','data_barang','data_supplier','barangs',
            'transaksis','suppliers','total_terjual'
        )); 
    }

     public function laporanPenjualan()
    {
        $transaksis = PenjualanDetail::with(['barang', 'penjualan.user'])
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('dashboard.owner', compact('transaksis'));
    }
    
}