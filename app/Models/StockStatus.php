<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockStatus extends Model
{
    protected $fillable = [
        'stockable_id',
        'stockable_type',
        'is_below_minimum',
    ];
}