<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiStok extends Model
{
    protected $table = 'notifikasi_stok';
    protected $fillable = ['barang_id', 'stok_sekarang', 'stok_minimum', 'is_read'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id')->withDefault([
        'nama_barang' => 'Barang Telah Dihapus'
    ]);
    }
}