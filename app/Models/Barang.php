<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Barang extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'user_id',
        'date',
        'name',
        'description',
        'jumlah',
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

public function getLastTransactionDateAttribute()
{
    $lastMasuk = $this->barangMasuks()->latest('date')->first();
    $lastKeluar = $this->barangKeluars()->latest('date')->first();

    $lastDates = collect([
        optional($lastMasuk)->date,
        optional($lastKeluar)->date,
    ])->filter();

    return $lastDates->sortDesc()->first();
}

}
