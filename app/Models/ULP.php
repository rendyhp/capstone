<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ULP extends Model
{
    use HasFactory;

    protected $table = 'ulp';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'ulp_nama',
        'ulp_alamat',
        'ulp_latitude',
        'ulp_longitude',
        'up_id', // Pastikan kolom up_id ada di tabel 'ulp'
    ];

    public function up()
    {
        return $this->belongsTo(UP::class, 'up_id');
    }
    public function trans()
    {
        return $this->hasMany('App\Models\ULP', 'trans_id', 'id');
    }


}
