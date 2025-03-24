<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Bahan extends Model
{
    use HasFactory;

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
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }
}


