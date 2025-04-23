<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahans';

    protected $casts = [
        'minimum' => 'decimal:3',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'minimum',
        'satuan_id',
    ];

    // Relasi ke tabel satuan
    public function satuan()
    {
        return $this->belongsTo(SatuanBahan::class, 'satuan_id');
    }
    

    public function bahanAkhir()
    {
        return $this->hasMany(BahanAkhir::class, 'bahan_id');
    }

    public function bahanAwal()
    {
        return $this->hasMany(BahanAwal::class, 'bahan_id');
    }

    public function bahanMasuk()
    {
        return $this->hasMany(BahanMasuk::class, 'bahan_id');
    }

    public function komposisiMenu()
    {
        return $this->hasMany(KomposisiMenu::class, 'bahan_id');
    }

    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'bahan_id');
    }
    
}


