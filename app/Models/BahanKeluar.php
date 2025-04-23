<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanKeluar extends Model
{
    use HasFactory;

    protected $casts = [
        'jumlah' => 'decimal:3',
    ];

    protected $fillable = [
        'user_id',
        'date',
        'bahan_id',
        'jumlah',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Bahan model
    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }



}
