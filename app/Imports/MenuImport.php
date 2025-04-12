<?php

namespace App\Imports;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class MenuImport implements ToModel
{
    public function model(array $row)
    {
        return new Menu([
            'user_id' => Auth::id(), // atau bisa pakai ID default jika perlu
            'name' => $row[0],
            'description' => $row[1] ?? null,
            'image' => null,
        ]);
    }
}