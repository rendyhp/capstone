<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'barang';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'barang_code',
        'barang_nama',
        'barang_merk',
        'barang_jenis',
        'barang_tipe',
        'barang_satuan',
    ];
    public static function generateBarang()
    {
        $latestBarang = static::latest()->first();
        if ($latestBarang) {
            $lastCodeNumber = (int) substr($latestBarang->barang_code, 2);
            $newCodeNumber = $lastCodeNumber + 1;
        } else {
            $newCodeNumber = 1;
        }

            $availableCodeNumber = $newCodeNumber;
            $attempts = 0;

        while (static::where('barang_code', 'B' . str_pad($availableCodeNumber, 3, '0', STR_PAD_LEFT))->exists()) {
            $attempts++;
            $availableCodeNumber = $newCodeNumber + $attempts;
        }

        $newCode = 'B' . str_pad($availableCodeNumber, 3, '0', STR_PAD_LEFT);
        return $newCode;
    }
        
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'barang_id');
    }

    
}
