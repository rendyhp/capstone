<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Satuan extends Model
{
    use HasFactory;

    protected $table = 'satuans';
    protected $casts = [
        'jumlah' => 'decimal:3',
    ];

    protected $fillable = [
        'user_id',
        'name',
    ];

}
