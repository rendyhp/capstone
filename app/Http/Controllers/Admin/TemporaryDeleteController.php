<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bahan;
use App\Models\Barang;
use App\Models\Menu;

class TemporaryDeleteController extends Controller
{
    protected function checkAccess()
    {
        $role = Auth::user()->role;
        if (!in_array($role, ['OWNER', 'MANAJER'])) {
            abort(443, 'Anda tidak memiliki akses!');
        }
    }

    public function indexBahan(Request $request)
    {
        $this->checkAccess();

        $orderBy = $request->input('orderBy', 'name');
        $direction = $request->input('direction', 'asc');

        $query = Bahan::with('satuan')
            ->whereNotNull('deleted_at')
            ->orderBy($orderBy, $direction);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $bahans = $query->paginate(20)->withQueryString();

        return view('temporary-delete.bahan', compact('bahans'));
    }

    public function restoreBahan(Request $request, $id)
    {
        $this->checkAccess();

        $bahan = Bahan::whereNotNull('deleted_at')->findOrFail($id);
        $bahan->deleted_at = null;
        $bahan->save();

        return redirect()->back()->with('success', 'Bahan "' . $bahan->name . '" berhasil direstore.');
    }


    public function indexBarang(Request $request)
    {
        $this->checkAccess();

        $orderBy = $request->input('orderBy', 'name');
        $direction = $request->input('direction', 'asc');

        $query = Barang::with('satuanBarang')
            ->whereNotNull('deleted_at')
            ->orderBy($orderBy, $direction);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $barangs = $query->paginate(20)->withQueryString();

        return view('temporary-delete.barang', compact('barangs'));
    }

    public function restoreBarang(Request $request, $id)
    {
        $this->checkAccess();

        $barang = Barang::whereNotNull('deleted_at')->findOrFail($id);
        $barang->deleted_at = null;
        $barang->save();

        return redirect()->back()->with('success', 'Barang "' . $barang->name . '" berhasil direstore.');
    }



    public function indexMenu(Request $request)
    {
        $this->checkAccess();

        $orderBy = $request->input('orderBy', 'name');
        $direction = $request->input('direction', 'asc');

        $query = Menu::with('komposisi.bahan.satuan')
            ->whereNotNull('deleted_at')
            ->orderBy($orderBy, $direction);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $menus = $query->paginate(20)->withQueryString();

        return view('temporary-delete.menu', compact('menus'));
    }

    public function restoreMenu(Request $request, $id)
    {
        $this->checkAccess();

        $menu = Menu::whereNotNull('deleted_at')->findOrFail($id);
        $menu->deleted_at = null;
        $menu->save();

        return redirect()->back()->with('success', 'Menu "' . $menu->name . '" berhasil direstore.');
    }

}
