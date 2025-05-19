<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'user_id',
        'name',
        'description',
        'jumlah',
        'minimum',
        'satuan_id',
        'image',
    ];

    public function satuanBarang()
    {
        return $this->belongsTo(SatuanBarang::class, 'satuan_id');
    }

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }
    public function barangAwals()
    {
        return $this->hasMany(BarangAwal::class);
    }

}
