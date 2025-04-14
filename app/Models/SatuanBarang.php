<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanBarang extends Model
{
    use HasFactory;

    protected $table = 'satuan_barangs';

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'satuan_id');
    }
    
}
