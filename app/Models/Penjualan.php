<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    // Nama tabel jika bukan jamak dari nama model (opsional)
    protected $table = 'penjualan'; 

    // Daftarkan semua kolom yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'kode_transaksi',
        'nama_pembeli',
        'total',      // Sesuaikan jika nama kolomnya 'total' atau 'total_harga'
        'tanggal',
        'user_id',      // Sesuaikan jika nama kolomnya 'users' atau 'user_id'
    ];

    public function user()
    {
        // Mengasumsikan kolom di tabel penjualan adalah 'user_id'
        return $this->belongsTo(User::class, 'user_id');
    }
    public function penjualanDetail()
    {
        // Relasi One-to-Many: Satu Penjualan punya banyak Detail
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }
}