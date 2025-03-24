<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Satuan;


class SearchController extends Controller
{
    public function searchSatuan(Request $request)
    {
        $query = $request->input('q');
        $results = Satuan::where('name', 'LIKE', "%{$query}%")
            ->take(10)
            ->get(['id', 'name']);

        return response()->json($results);
    }
    
}
