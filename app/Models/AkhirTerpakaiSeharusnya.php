<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class AkhirTerpakaiSeharusnya extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'bahan_id',
        'jumlah',
    ];
}
