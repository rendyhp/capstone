<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function gambaran_umum()
    {
        return view('pages.guest.menu.gambaran_umum');
    }

    public function sarana_kesehatan()
    {
        return view('pages.guest.menu.sarana_kesehatan');
    }

    public function sdm_kesehatan()
    {
        return view('pages.guest.menu.sdm_kesehatan');
    }
    public function pembiayaan_kesehatan()
    {
        return view('pages.guest.menu.pembiayaan_kesehatan');
    }

    public function kesehatan_keluarga()
    {
        return view('pages.guest.menu.kesehatan_keluarga');
    }

    public function pengendalian_penyakit()
    {
        return view('pages.guest.menu.pengendalian_penyakit');
    }
    public function kesehatan_lingkungan()
    {
        return view('pages.guest.menu.kesehatan_lingkungan');
    }
}
