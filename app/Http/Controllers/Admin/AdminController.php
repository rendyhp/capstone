<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Dataset;
use App\Models\Publication;


class AdminController extends Controller
{
    public function index()
    {
        $countPublication = Publication::count();
        $countDataset = Dataset::count();

        return view('pages.admin.dashboard.index', compact('countPublication', 'countDataset'));
    }

}