<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class AkhirTerpakaiSeharusnya extends Model
{
    use HasFactory;
    protected $casts = [
        'jumlah' => 'decimal:3',
    ];

    protected $fillable = [
        'date',
        'bahan_id',
        'jumlah',
    ];
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
}
