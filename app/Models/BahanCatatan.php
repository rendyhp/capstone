<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanCatatan extends Model
{
    use HasFactory;

    protected $table = 'bahan_catatans';

    protected $fillable = [
        'user_id',
        'date',
        'bahan_id',
        'catatan',
    ];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
