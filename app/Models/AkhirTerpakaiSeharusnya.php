<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class AkhirTerpakaiSeharusnya extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'id_bahan',
        'jumlah',
        'satuan_id',
    ];

    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
