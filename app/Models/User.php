<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username',
        'password',
        'role',
    ];
    protected $hidden = [
        'password',
    ];


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKasir()
    {
        return $this->role === 'kasir';
    }

    public function isOwner()
    {
        return $this->role === 'owner';
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }
}
