<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'detail_transaksi';
    protected $fillable = [
        'id',
        'trans_id',
        'barang_id',
        'barang_quantity',
        'barang_sn',
        'status',
        'keterangan'
    ];
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'trans_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class,'barang_id');
    }
}