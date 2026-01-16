<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // =========================================================================
    // 1. NAVIGASI & LAPORAN UTAMA
    // =========================================================================
    public function index(Request $request)
    {
        // 1. Inisialisasi Parameter Filter Waktu
        $bulanInput = $request->get('bulan', date('Y-m')); 
        $bulan      = $request->get('bulan', date('m')); 
        $tahun      = $request->get('tahun', date('Y')); 
        $from       = $request->get('from');
        $to         = $request->get('to');

        // 2. Data Statistik (Card Atas)
        $total_barang   = Barang::count();
        $total_supplier = Supplier::count();
        $rusak          = Barang::where('stok', '<', 5)->count();
        $baik           = Barang::where('stok', '>=', 5)->count();
        $grafik         = Barang::orderBy('stok', 'desc')->take(5)->get();

        // 3. Logika Filter Utama (INI YANG SAYA PERBAIKI)
        $suppliers = Supplier::withCount('barangs')->get();
        $data_supplier = $suppliers; 
        
        // Default inisialisasi agar tidak error di view
        $data_barang = collect();
        $barangs = collect();

        if ($request->status == 'kritis') {
            // HANYA ambil yang benar-benar kritis
            $barangs = Barang::with('supplier')->where('stok', '<', 5)->get();
            $data_barang = $barangs; 
        } elseif ($request->supplier_id) {
            // Filter per supplier
            $data_barang = Barang::where('supplier_id', $request->supplier_id)->get();
            $barangs = collect();
        } else {
            // Mode awal: Tampilkan semua barang untuk variabel pendukung, 
            // tapi data_barang dikosongkan agar view tidak bingung
            $barangs = Barang::with('supplier')->latest()->get();
            $data_barang = collect();
        }

        // 4. Logika Laporan Mutasi & Transaksi (Tetap seperti kode kamu)
        $laporans = Barang::all()->map(function ($barang) use ($tahun, $bulan) {
            $masuk = BarangMasuk::where('barang_id', $barang->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('jumlah');
            $keluar = PenjualanDetail::where('barang_id', $barang->id)->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->sum('qty');
            $stok_akhir = $barang->stok; 
            $stok_awal  = $stok_akhir - $masuk + $keluar;
            return (object) ['nama_barang' => $barang->nama_barang, 'stok_awal' => $stok_awal, 'qty_masuk' => $masuk, 'qty_keluar' => $keluar, 'stok_akhir' => $stok_akhir, 'harga' => $barang->harga_jual];
        });

        $query_penjualan = PenjualanDetail::with(['barang', 'penjualan.user'])->orderBy('created_at', 'desc');
        if ($request->filled('from') && $request->filled('to')) {
            $query_penjualan->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }
        $transaksis = (clone $query_penjualan)->paginate(10);
        $total_terjual = (clone $query_penjualan)->sum('qty');
        $total_aset = Barang::all()->sum(fn($b) => $b->stok * $b->harga_jual);

        // 5. Kembalikan ke View
        return view('dashboard.admin', compact(
            'total_barang', 'total_supplier', 'rusak', 'baik', 
            'grafik', 'data_barang', 'data_supplier', 'suppliers', 
            'barangs', 'transaksis', 'total_aset', 'total_terjual', 
            'bulanInput', 'from', 'to', 'bulan', 'tahun', 'laporans'
        ));
    }

    // =========================================================================
    // 2. LOGIKA KELOLA BARANG (CRUD & MUTASI)
    // =========================================================================
    public function storeBarang(Request $request) 
    {
        $request->validate([
            'nama_barang' => 'required',
            'stok'        => 'required|numeric',
            'harga_jual'  => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        // Simpan data barang
        $barang = Barang::create($request->all());

        // Catat riwayat mutasi masuk awal
        BarangMasuk::create([
            'barang_id'   => $barang->id,
            'supplier_id' => $request->supplier_id,
            'user_id'     => auth()->id(),
            'jumlah'      => $request->stok,
            'tanggal'     => now(),
            'harga_beli'  => $request->harga_jual,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambah!');
    }

    public function updateBarang(Request $request, $id) 
    {
        $barang = Barang::findOrFail($id);
        $stokLama = $barang->stok;
        $stokBaru = $request->stok;

        // Update data barang
        $barang->update($request->all());

        // Jika stok bertambah, catat selisihnya ke BarangMasuk
        if ($stokBaru > $stokLama) {
            $selisih = $stokBaru - $stokLama;
            BarangMasuk::create([
                'barang_id'   => $barang->id,
                'supplier_id' => $barang->supplier_id,
                'user_id'     => auth()->id(),
                'jumlah'      => $selisih,
                'tanggal'     => now(),
                'harga_beli'  => $barang->harga_jual,
            ]);
        }

        return redirect()->back()->with('success', 'Barang berhasil diupdate dan mutasi dicatat!');
    }

    public function destroyBarang($id) 
    {
        Barang::destroy($id);
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    public function barang(Request $request)
    {
        // Jika ada klik dari card stok kritis
        if ($request->status == 'kritis') {
            $data_barang = Barang::where('stok', '<', 5)->get();
        } else {
            // Logika kamu yang sekarang (misal filter per supplier)
            $data_barang = Barang::where('supplier_id', $request->supplier_id)->get();
        }

        return view('dashboard.admin', compact('data_barang'));
    }

    // =========================================================================
    // 3. LOGIKA KELOLA SUPPLIER
    // =========================================================================
    public function storeSupplier(Request $request) 
    {
        $request->validate(['nama_supplier' => 'required', 'no_hp' => 'required', 'alamat' => 'required']);
        Supplier::create($request->all());
        return redirect()->back()->with('success', 'Supplier berhasil ditambah!');
    }

    public function updateSupplier(Request $request, $id) 
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->back()->with('success', 'Supplier berhasil diupdate!');
    }

    public function destroySupplier($id) 
    {
        Supplier::destroy($id);
        return redirect()->back()->with('success', 'Supplier berhasil dihapus!');
    }

    // =========================================================================
    // 4. LAPORAN TAMBAHAN
    // =========================================================================
    public function laporanPenjualan()
    {
        $transaksis = PenjualanDetail::with(['barang', 'penjualan.user'])
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('dashboard.admin', compact('transaksis'));
    }
}