<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UP extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'up';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'up_nama',
        'up_alamat',
        'latitude',
        'longitude',
    ];
    public function ulp()
    {
        return $this->hasMany('App\Models\ULP', 'up_id', 'id');
    }
    public function trans()
    {
        return $this->hasMany('App\Models\ULP', 'trans_id', 'id');
    }
    public function user()
    {
        return $this->hasMany('App\Models\User', 'up_id' , 'id');
    }

}
