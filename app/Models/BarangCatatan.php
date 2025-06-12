<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangCatatan extends Model
{
    use HasFactory;

    protected $table = 'barang_catatans';

    protected $fillable = [
        'user_id',
        'date',
        'barang-id',
        'catatan',
    ];

    public function barang()
    {
        return $this->belongsTo(Bahan::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
