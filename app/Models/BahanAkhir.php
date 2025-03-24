<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class BahanAkhir extends Model
{
    use HasFactory;

    protected $table = 'bahan_akhirs';

    protected $fillable = [
        'user_id',
        'date',
        'bahan_id',
        'jumlah'
    ];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }

}
