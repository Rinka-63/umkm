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
        // --- 1. Statistik (Tetap sama) ---
        $total_barang   = Barang::count();
        $total_supplier = Supplier::count();
        $rusak          = Barang::where('stok', '<=', 5)->count();
        $baik           = Barang::where('stok', '>', 5)->count();
        $grafik         = Barang::orderBy('stok', 'desc')->take(5)->get();

        // --- 2. Data Master (Untuk Dropdown/Grid) ---
        $data_supplier  = Supplier::latest()->get();
        $suppliers      = Supplier::withCount('barangs')->get();
        
        // --- 3. Logika Filter Utama (Hanya Satu Alur) ---
        if ($request->status == 'kritis') {
            // Jika minta barang kritis
            $data_barang = Barang::with('supplier')->where('stok', '<=', 5)->get();
            $barangs     = $data_barang; // Samakan agar tidak error di view
        } elseif ($request->supplier_id) {
            // Jika filter per supplier
            $data_barang = Barang::where('supplier_id', $request->supplier_id)->get();
            $barangs     = collect(); 
        } else {
            // Tampilan default (Awal)
            $data_barang = collect(); // Kosongkan agar view menampilkan grid supplier
            $barangs     = Barang::with('supplier')->latest()->get();
        }

        // --- 4. Riwayat Transaksi (Pagination disarankan agar tidak berat) ---
        $transaksis = PenjualanDetail::with('barang','penjualan')
                        ->orderBy('created_at', 'desc')
                        ->take(50) // Ambil 50 terbaru saja agar loading cepat
                        ->get();

        // --- 5. Filter Penjualan (Range Tanggal) ---
        $from = $request->from;
        $to   = $request->to;
        $total_terjual = PenjualanDetail::when($from && $to, function($query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
            })->sum('qty');

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