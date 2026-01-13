<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\BarangMasuk;
use App\Models\NotifikasiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // =========================================================================
    // 1. NAVIGASI & LAPORAN UTAMA
    // =========================================================================
    public function index(Request $request)
    {
        // --- Inisialisasi Parameter Filter ---
        $bulanInput = $request->get('bulan', date('Y-m')); // Digunakan untuk input month lama
        $bulan      = $request->get('bulan', date('m'));   // Untuk filter bulan terpisah
        $tahun      = $request->get('tahun', date('Y'));   // Untuk filter tahun terpisah
        $from       = $request->get('from');
        $to         = $request->get('to');

        // --- Logika Laporan Mutasi Stok ---
        $laporans = Barang::all()->map(function ($barang) use ($tahun, $bulan) {
            // Hitung total masuk di periode terpilih
            $masuk = BarangMasuk::where('barang_id', $barang->id)
                        ->whereYear('tanggal', $tahun)
                        ->whereMonth('tanggal', $bulan)
                        ->sum('jumlah');

            // Hitung total keluar di periode terpilih
            $keluar = PenjualanDetail::where('barang_id', $barang->id)
                        ->whereYear('created_at', $tahun)
                        ->whereMonth('created_at', $bulan)
                        ->sum('qty');

            // Stok Akhir (Angka saat ini di DB) & Stok Awal (Hitung Mundur)
            $stok_akhir = $barang->stok; 
            $stok_awal  = $stok_akhir - $masuk + $keluar;

            return (object) [
                'nama_barang' => $barang->nama_barang,
                'stok_awal'   => $stok_awal,
                'qty_masuk'   => $masuk,
                'qty_keluar'  => $keluar,
                'stok_akhir'  => $stok_akhir,
                'harga'       => $barang->harga_jual
            ];
        });

        // --- Logika Filter Penjualan & Transaksi ---
        $query_penjualan = PenjualanDetail::with(['barang', 'penjualan.user'])->orderBy('created_at', 'desc');
        
        if ($request->filled('from') && $request->filled('to')) {
            $query_penjualan->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }
        
        // Data untuk tabel transaksi (Pagination)
        $transaksis = (clone $query_penjualan)->paginate(10);
        
        // Hitung total volume terjual berdasarkan filter
        $total_terjual = (clone $query_penjualan)->sum('qty');

        // --- Data Statistik Dashboard ---
        $total_barang   = Barang::count();
        $total_supplier = Supplier::count();
        $rusak          = Barang::where('stok', '<=', 5)->count();
        $baik           = Barang::where('stok', '>', 5)->count();
        $grafik         = Barang::orderBy('stok', 'desc')->take(5)->get();
        
        // --- Data Master & Notifikasi ---
        $data_barang    = Barang::latest()->get();
        $data_supplier  = Supplier::latest()->get();
        $notif_count    = $rusak;
        $notif_list     = NotifikasiStok::with('barang')->latest()->orderBy('created_at', 'desc')->get();

        // --- Data Laporan Lain-lain ---
        $data_penjualan       = Penjualan::latest()->get();
        $data_barang_tersedia = Barang::where('stok', '>', 0)->get();
        $laporan_stok         = Barang::all();
        $laporan_penjualan    = Penjualan::with('penjualanDetail.barang')->latest()->get();
        $laporan_masuk        = BarangMasuk::with('supplier', 'barang')->latest()->get();
        
        // --- Data Aset & Inventaris ---
        $barangs = Barang::with('supplier')->latest()->get();
        $total_aset = $barangs->sum(function($barang) {
            return $barang->stok * $barang->harga_jual;
        });

        $laporans_stok = Barang::select('nama_barang', 'stok as stok_awal', 'stok as stok_akhir', 'harga_jual as harga')->get();
        $all_barangs   = Barang::orderBy('nama_barang')->get();

        // --- Filter Supplier Khusus ---
        $suppliers  = Supplier::withCount('barangs')->get();
        $supplierId = request('supplier_id');
        $data_barang = Barang::when($supplierId, function($query) use ($supplierId) {
            return $query->where('supplier_id', $supplierId);
        })->get();

        // --- Pengembalian View ---
        return view('dashboard.admin', compact(
            'total_barang', 'total_supplier', 'rusak', 'baik', 
            'grafik', 'data_barang', 'data_barang_tersedia', 'data_supplier', 
            'notif_count', 'notif_list', 'data_penjualan',
            'laporan_stok', 'laporan_penjualan', 'all_barangs', 'laporans',
            'transaksis', 'barangs', 'total_aset', 'suppliers', 'total_terjual', 
            'bulanInput', 'laporans_stok', 'from', 'to', 'bulan', 'tahun'
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

        // Cek Notifikasi Stok Menipis
        if ($barang->stok <= 5) {
            NotifikasiStok::updateOrCreate(
                ['barang_id' => $barang->id],
                ['stok_sekarang' => $barang->stok, 'is_read' => false]
            );
        }

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

        // Kelola Notifikasi Stok
        if ($barang->stok <= 5) {
            NotifikasiStok::updateOrCreate(
                ['barang_id' => $barang->id],
                ['stok_sekarang' => $barang->stok, 'is_read' => false, 'updated_at' => now()]
            );
        } else {
            NotifikasiStok::where('barang_id', $barang->id)->delete();
        }

        return redirect()->back()->with('success', 'Barang berhasil diupdate dan mutasi dicatat!');
    }

    public function destroyBarang($id) 
    {
        Barang::destroy($id);
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
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