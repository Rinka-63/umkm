<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs'; // Sesuai nama tabelmu
    protected $fillable = ['nama_barang', 'stok', 'harga_jual','supplier_id'];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function notifikasiStok()
    {
        return $this->hasMany(NotifikasiStok::class);
    }

    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
    public function kategori()
{
    return $this->belongsTo(Kategori::class, 'kategori_id');
}
}