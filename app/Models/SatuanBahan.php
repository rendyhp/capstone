<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanBahan extends Model
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

    public function bahan()
    {
        return $this->hasMany(Bahan::class, 'satuan_id');
    }
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'satuan_id');
    }

}
