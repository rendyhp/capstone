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
        'date',
        'menu',
        'jumlah',
    ];
}
