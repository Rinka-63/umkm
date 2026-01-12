<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    // Nama tabel jika bukan jamak dari nama model (opsional)
    protected $table = 'penjualan_detail'; 

    // Daftarkan semua kolom yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'qty',
        'harga',
        'subtotal',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}