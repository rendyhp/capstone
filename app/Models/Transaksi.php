<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    public $incrementing = true;
    public $timestamps = false;
    protected $table = 'transaksi';
    protected $guarded = ['created_at', 'created_by'];
    protected $fillable = [
        'id',
        'tanggal_trans',
        'trans_jenis',
        'up_id',
        'ulp_id',
        'pemberi',
        'penerima',
        'created_by',
        'created_at',
    ];
    public function up()
    {
        return $this->belongsTo(UP::class, 'up_id');
    }

    public function ulp()
    {
        return $this->belongsTo(ULP::class, 'ulp_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function detail()
    {
        return $this->belongsTo(User::class, 'detail_id');
    }
    public static function generateTransaksi($transJenis)
    {
        // Tentukan kode awalan sesuai dengan jenis transaksi
        $kodeAwalan = ($transJenis == 'masuk') ? 'TM' : 'TK';

        // Ambil kode transaksi terakhir dari database berdasarkan jenis transaksi
        $latestTransaksi = static::where('trans_jenis', $transJenis)->latest()->first();

        if ($latestTransaksi) {
            $lastCodeNumber = (int) substr($latestTransaksi->kode_trans, 2);
            $newCodeNumber = $lastCodeNumber + 1;
        } else {
            $newCodeNumber = 1;
        }

        $availableCodeNumber = $newCodeNumber;
        $attempts = 0;

        while (static::where('kode_trans', $kodeAwalan . str_pad($availableCodeNumber, 2, '0', STR_PAD_LEFT))->exists()) {
            $attempts++;
            $availableCodeNumber = $newCodeNumber + $attempts;
        }

        $newCode = $kodeAwalan . str_pad($availableCodeNumber, 2, '0', STR_PAD_LEFT);
        return $newCode;
    }
}
