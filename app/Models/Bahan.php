<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'image',
    ];

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

    public function catatans()
    {
        return $this->hasMany(BahanCatatan::class, 'bahan_id');
    }

    public function catatanByDate($date)
    {
        return $this->catatans()->whereDate('date', $date)->first();
    }


}


