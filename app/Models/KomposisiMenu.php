<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomposisiMenu extends Model
{
    use HasFactory;

    protected $casts = [
        'jumlah' => 'decimal:3',
    ];

    protected $fillable = [
        'menu_id',
        'bahan_id',
        'jumlah',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
}
