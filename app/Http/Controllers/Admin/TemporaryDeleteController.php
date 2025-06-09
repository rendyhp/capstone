<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
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

        $orderBy = $request->input('orderBy', 'deleted_at');
        $direction = $request->input('direction', 'desc');
        $cutoffDate = Carbon::today()->subDays(30);

        $query = Bahan::with('satuan')
            ->whereNotNull('deleted_at')
            ->where('deleted_at', '>=', $cutoffDate)
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

        return redirect()->back()->with('success', 'Bahan "' . $bahan->name . '" berhasil dikembalikan.');
    }


    public function indexBarang(Request $request)
    {
        $this->checkAccess();

        $orderBy = $request->input('orderBy', 'deleted_at');
        $direction = $request->input('direction', 'desc');
        $cutoffDate = Carbon::today()->subDays(30);

        $query = Barang::with('satuanBarang')
            ->whereNotNull('deleted_at')
            ->where('deleted_at', '>=', $cutoffDate)
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

        return redirect()->back()->with('success', 'Barang "' . $barang->name . '" berhasil dikembalikan.');
    }



    public function indexMenu(Request $request)
    {
        $this->checkAccess();

        $orderBy = $request->input('orderBy', 'deleted_at');
        $direction = $request->input('direction', 'desc');
        $cutoffDate = Carbon::today()->subDays(30);

        $query = Menu::with('komposisi.bahan.satuan')
            ->whereNotNull('deleted_at')
            ->where('deleted_at', '>=', $cutoffDate)
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

        return redirect()->back()->with('success', 'Menu "' . $menu->name . '" berhasil dikembalikan.');
    }

    public function forceDeleteBahan(Request $request)
    {
        $this->checkAccess();
        $bahan = Bahan::findOrFail($request->id);
        $bahan->deleted_at = Carbon::parse('2015-05-15');
        $bahan->save();
        return redirect()->back()->with('success', 'Bahan "' . $bahan->name . '" berhasil dihapus permanen.');
    }

    public function forceDeleteBarang(Request $request)
    {
        $this->checkAccess();
        $barang = Barang::findOrFail($request->id);
        $barang->deleted_at = Carbon::parse('2015-05-15');
        $barang->save();
        return redirect()->back()->with('success', 'Barang "' . $barang->name . '" berhasil dihapus permanen.');
    }

    public function forceDeleteMenu(Request $request)
    {
        $this->checkAccess();
        $menu = Menu::findOrFail($request->id);
        $menu->deleted_at = Carbon::parse('2015-05-15');
        $menu->save();
        return redirect()->back()->with('success', 'Menu "' . $menu->name . '" berhasil dihapus permanen.');
    }
}
