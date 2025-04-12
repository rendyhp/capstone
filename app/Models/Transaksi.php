<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Transaksi extends Model
{
    use HasFactory;
    
    protected $casts = [
        'jumlah' => 'decimal:3',
    ];

    protected $fillable = [
        'user_id',
        'menu_id', // Mengubah dari 'menu' ke 'menu_id'
        'date',
        'jumlah',
        'catatan'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}

