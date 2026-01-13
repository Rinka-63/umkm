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
    // =========================================================================
    // 1. DASHBOARD UTAMA (MONITORING OWNER)
    // =========================================================================
    public function index(Request $request)
    {
        // --- Statistik Ringkas (Cards) ---
        $total_barang   = Barang::count();
        $total_supplier = Supplier::count();
        $rusak          = Barang::where('stok', '<=', 5)->count();
        $baik           = Barang::where('stok', '>', 5)->count();
        $grafik         = Barang::orderBy('stok', 'desc')->take(5)->get();

        // --- Data Master & Stok ---
        $data_supplier  = Supplier::latest()->get();
        $barangs        = Barang::where('stok', '>', 0)->get();
        $suppliers      = \App\Models\Supplier::withCount('barangs')->get();
        
        // --- Riwayat Transaksi Penjualan ---
        $transaksis     = PenjualanDetail::with('barang','penjualan')
                            ->orderBy('created_at', 'desc')
                            ->get();

        // --- Logika Filter Barang Berdasarkan Supplier ---
        $supplierId     = request('supplier_id');
        $data_barang    = \App\Models\Barang::when($supplierId, function($query) use ($supplierId) {
            return $query->where('supplier_id', $supplierId);
        })->get();

        // --- Logika Filter Volume Terjual (Range Tanggal) ---
        $from = $request->from;
        $to   = $request->to;

        $total_terjual = PenjualanDetail::when($from && $to, function($query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
            })
            ->sum('qty');

        // --- Return View Dashboard Owner ---
        return view('dashboard.owner', compact(
            'total_barang','total_supplier','rusak','baik',
            'grafik','data_barang','data_supplier','barangs',
            'transaksis','suppliers','total_terjual'
        )); 
    }

    // =========================================================================
    // 2. LAPORAN PENJUALAN KESELURUHAN
    // =========================================================================
    public function laporanPenjualan()
    {
        // Mengambil semua transaksi dengan detail barang dan kasir yang bertugas
        $transaksis = PenjualanDetail::with(['barang', 'penjualan.user'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('dashboard.owner', compact('transaksis'));
    }
}