<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangAwal extends Model
{
    use HasFactory;

    protected $casts = [
        'jumlah' => 'decimal:3',
    ];

    protected $fillable = [
        'user_id',
        'date',
        'keterangan',
        'barang_id',
        'jumlah',
    ];

    public function barang() {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
