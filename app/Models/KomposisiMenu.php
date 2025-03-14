<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomposisiMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_menu',
        'id_bahan',
        'jumlah',
    ];

}
