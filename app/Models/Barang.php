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
}
