<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Penjualan;
use App\Models\NotifikasiStok;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ================= LOGIN =================
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.beranda');
                case 'kasir':
                    return redirect()->route('kasir.beranda');
                case 'owner':
                    return redirect()->route('owner.beranda');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Role tidak dikenali');
            }
        }

        return back()->with('error', 'Username atau password salah!');
    }

    // ================= LOGOUT =================
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // ================= DASHBOARD =================
    public function adminDashboard()
    {
        // Statistik Utama
        $total_barang   = Barang::count();
        $total_supplier = Supplier::count();
        $total_terjual = \App\Models\PenjualanDetail::sum('qty') ?? 0;// Sesuaikan dengan logika tabel penjualan Anda
        
        // Notifikasi Stok (Lonceng)
        $notif_count = NotifikasiStok::where('is_read', 0)->count();
        $notif_list  = NotifikasiStok::with('barang')->where('is_read', 0)->latest()->take(5)->get();

        // Data Grafik: Stok Barang
        $grafik = Barang::orderBy('stok', 'desc')->take(5)->get();

        // Data Grafik: Kondisi Stok (Aman vs Kritis)
        $baik = Barang::whereRaw('stok > 10')->count();
        $rusak = Barang::whereRaw('stok <= 10')->count();

        return view('dashboard.admin', compact(
            'total_barang', 
            'total_supplier', 
            'total_terjual', 
            'notif_count', 
            'notif_list',
            'baik', 
            'rusak', 
            'grafik'
        ));
    }

    public function kasirDashboard()
    {
        return view('dashboard.kasir');
    }

    public function ownerDashboard()
    {
        return view('dashboard.owner');
    }
}
