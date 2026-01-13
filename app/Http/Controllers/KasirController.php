<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Supplier;
use App\Models\NotifikasiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;

class KasirController extends Controller
{
    // =========================================================================
    // 1. DASHBOARD UTAMA (INDEX)
    // =========================================================================
    public function index(Request $request)
    {
        // --- Statistik Ringkas Dashboard ---
        $total_barang   = Barang::count();
        $total_supplier = Supplier::count();
        $rusak          = Barang::where('stok', '<=', 5)->count();
        $baik           = Barang::where('stok', '>', 5)->count();
        $grafik         = Barang::orderBy('stok', 'desc')->take(5)->get();

        // --- Data Master ---
        $data_supplier  = Supplier::latest()->get();
        $barangs        = Barang::where('stok', '>', 0)->get(); // Barang untuk pilihan kasir
        $suppliers      = \App\Models\Supplier::withCount('barangs')->get();

        // --- Riwayat Transaksi Penjualan ---
        $transaksis = PenjualanDetail::with('barang','penjualan')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // --- Filter Data Barang (Berdasarkan Supplier) ---
        $supplierId  = request('supplier_id');
        $data_barang = \App\Models\Barang::when($supplierId, function($query) use ($supplierId) {
            return $query->where('supplier_id', $supplierId);
        })->get();

        // --- Filter Volume Terjual (Berdasarkan Range Tanggal) ---
        $from = $request->from;
        $to   = $request->to;

        $total_terjual = PenjualanDetail::when($from && $to, function($query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
            })
            ->sum('qty');

        return view('dashboard.kasir', compact(
            'total_barang','total_supplier','rusak','baik',
            'grafik','data_barang','data_supplier','barangs',
            'transaksis','suppliers','total_terjual'
        )); 
    }

    // =========================================================================
    // 2. PROSES TRANSAKSI PENJUALAN
    // =========================================================================
    
    // Form Tambah Transaksi
    public function create() {
        $barangs = Barang::where('stok', '>', 0)->get();
        return view('dashboard.kasir', compact('barangs'));
    }

    // Simpan Transaksi ke Database
    public function storePenjualan(Request $request) 
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'barang_id'    => 'required|exists:barangs,id',
            'jumlah'       => 'required|numeric|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Validasi Ketersediaan Stok
        if ($barang->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok ' . $barang->nama_barang . ' tidak cukup!');
        }

        try {
            DB::transaction(function () use ($request, $barang) {
                $total_harga = $barang->harga_jual * $request->jumlah;
                
                // Generate Kode Transaksi Otomatis
                $kode_transaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

                // 1. Simpan Header Penjualan
                $penjualan = Penjualan::create([
                    'kode_transaksi' => $kode_transaksi,
                    'nama_pembeli'   => $request->nama_pembeli,
                    'total'          => $total_harga, 
                    'tanggal'        => now(),
                    'user_id'        => auth()->id(), 
                ]);

                // 2. Simpan Detail Item Penjualan
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id'    => $request->barang_id,
                    'qty'          => $request->jumlah,
                    'harga'        => $barang->harga_jual,
                    'subtotal'     => $total_harga,
                ]);

                // 3. Update Stok Barang (Potong Stok)
                $barang->decrement('stok', $request->jumlah);

                // --- Bonus: Cek jika stok setelah dipotong menjadi menipis ---
                if ($barang->stok <= 5) {
                    NotifikasiStok::updateOrCreate(
                        ['barang_id' => $barang->id],
                        ['stok_sekarang' => $barang->stok, 'is_read' => false]
                    );
                }
            });

            return redirect()->back()->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // 3. LAPORAN PENDAPATAN KASIR
    // =========================================================================
    public function laporan(Request $request)
    {
        // Filter Berdasarkan Tanggal (Default: Hari Ini)
        $tanggal = $request->get('tanggal', date('Y-m-d'));

        // Ambil Data Penjualan Kasir yang sedang login pada tanggal terpilih
        $laporan_hari_ini = PenjualanDetail::with(['barang', 'penjualan'])
            ->whereHas('penjualan', function($query) use ($tanggal) {
                $query->where('user_id', auth()->id())
                      ->whereDate('created_at', $tanggal);
            })
            ->get();

        // Hitung Total Pendapatan dari Subtotal
        $total_pendapatan = $laporan_hari_ini->sum('subtotal');

        return view('dashboard.kasir', compact('laporan_hari_ini', 'total_pendapatan', 'tanggal'));
    }
}