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
    // --- NAVIGASI UTAMA ---
public function index(Request $request) // Tambahkan Request $request di sini
{
    // 1. Logika Filter Penjualan (Pindahkan dari fungsi penjualan ke sini)
    $query_penjualan = PenjualanDetail::with('barang')->orderBy('created_at', 'desc');
    
    if ($request->filled('from') && $request->filled('to')) {
        $query_penjualan->whereBetween('created_at', [
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59'
        ]);
    }
    $transaksis = $query_penjualan->get();

    // 2. Data Dashboard (Tetap ada)
    $total_barang = Barang::count();
    $total_supplier = Supplier::count();
    $rusak = Barang::where('stok', '<=', 5)->count();
    $baik = Barang::where('stok', '>', 5)->count();
    $grafik = Barang::orderBy('stok', 'desc')->take(5)->get();
    
    $data_barang = Barang::latest()->get();
    $data_supplier = Supplier::latest()->get();

    $notif_count = $rusak;
    $notif_list = NotifikasiStok::with('barang')->latest()->orderBy('created_at', 'desc')->get();

    $data_penjualan = Penjualan::latest()->get();
    $data_barang_tersedia = Barang::where('stok', '>', 0)->get();

    $laporan_stok = Barang::all();
    $laporan_penjualan = Penjualan::with('penjualanDetail.barang')->latest()->get();
    $laporan_masuk = BarangMasuk::with('supplier', 'barang')->latest()->get();

    $barangs = Barang::with('supplier')->latest()->get();
    $total_aset = $barangs->sum(function($barang) {
        return $barang->stok * $barang->harga_jual;
    });

    $laporans = Barang::select('nama_barang', 'stok as stok_awal', 'stok as stok_akhir', 'harga_jual as harga')->get();
    $all_barangs = Barang::orderBy('nama_barang')->get();

    $transaksis = PenjualanDetail::with(['barang', 'penjualan.user'])
                  ->orderBy('created_at', 'desc')
                  ->paginate(10);

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

    // 3. Return dengan SEMUA data termasuk $transaksis
    return view('dashboard.admin', compact(
        'total_barang', 'total_supplier', 'rusak', 'baik', 
        'grafik', 'data_barang','data_barang_tersedia', 'data_supplier', 
        'notif_count', 'notif_list','data_penjualan',
        'laporan_stok', 'laporan_penjualan','all_barangs','laporans',
        'transaksis','barangs','total_aset','suppliers','total_terjual'
    ));
}

    // --- LOGIKA BARANG ---
    public function storeBarang(Request $request) {
        $request->validate([
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $barang = Barang::create($request->all());

        // CEK STOK: Jika stok awal yang diinput sudah menipis (<= 5)
        if ($barang->stok <= 5) {
            NotifikasiStok::updateOrCreate(
                ['barang_id' => $barang->id],
                ['stok_sekarang' => $barang->stok, 'is_read' => false]
            );
        }

        return redirect()->back()->with('success', 'Barang berhasil ditambah!');
    }

    public function updateBarang(Request $request, $id) {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        // CEK STOK: Jika setelah diupdate stoknya menipis
        if ($barang->stok <= 5) {
            NotifikasiStok::updateOrCreate(
                ['barang_id' => $barang->id],
                [
                    'stok_sekarang' => $barang->stok,
                    'is_read' => false,
                    'updated_at' => now() // Agar notif naik ke paling atas
                ]
            );
        } else {
            // OPSIONAL: Hapus notifikasi jika stok sudah ditambah (tidak menipis lagi)
            NotifikasiStok::where('barang_id', $barang->id)->delete();
        }

        return redirect()->back()->with('success', 'Barang berhasil diupdate!');
    }

    public function destroyBarang($id) {
        Barang::destroy($id);
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    // --- LOGIKA SUPPLIER ---
    public function storeSupplier(Request $request) {
        $request->validate(['nama_supplier' => 'required', 'kontak' => 'required', 'alamat' => 'required']);
        Supplier::create($request->all());
        return redirect()->back()->with('success', 'Supplier berhasil ditambah!');
    }

    public function updateSupplier(Request $request, $id) {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->back()->with('success', 'Supplier berhasil diupdate!');
    }

    public function destroySupplier($id) {
        Supplier::destroy($id);
        return redirect()->back()->with('success', 'Supplier berhasil dihapus!');
    }

    public function laporanPenjualan()
    {
        $transaksis = PenjualanDetail::with(['barang', 'penjualan.user'])
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('dashboard.admin', compact('transaksis'));
    }



}