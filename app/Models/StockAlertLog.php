<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAlertLog extends Model
{
    protected $fillable = ['stockable_id', 'stockable_type', 'alert_date'];

    public function stockable()
    {
        return $this->morphTo();
    }
}
