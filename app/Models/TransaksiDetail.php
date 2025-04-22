<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'jumlah' => 'decimal:3',
    ];

    protected $fillable = [
        'transaksi_id',
        'bahan_id',
        'jumlah',
        'satuan_id'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
    public function satuan()
    {
        return $this->belongsTo(SatuanBahan::class);
    }
}
