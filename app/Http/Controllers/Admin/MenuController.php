<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Barang;
use App\Models\KomposisiMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $orderBy = $request->input('orderBy', 'name');
        $direction = $request->input('direction', 'asc');

        $bahans = Bahan::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        $query = Menu::with('komposisi.bahan.satuan')
            ->whereNull('deleted_at');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->orderBy($orderBy, $direction);

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            $menus = $query->paginate(20)->withQueryString();

            return view('daftar-menu.index', [
                'menus' => $menus,
                'bahans' => $bahans
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);
        $user = Auth::user()->id;

        if ($request->bahan != null) {
            if ($request->has('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                $filename = time() . '.' . $extension;

                $path = 'upload/menu/';
                $file->move($path, $filename);

                $menu = Menu::create([
                    'user_id' => $user,
                    'name' => $request->name,
                    'description' => $request->description,
                    'image' => $path . $filename,
                ]);
            } else {
                $menu = Menu::create([
                    'user_id' => $user,
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
            }

            foreach ($request->bahan as $bahan) {
                KomposisiMenu::create([
                    'menu_id' => $menu->id,
                    'bahan_id' => $bahan['id'],
                    'jumlah' => $bahan['jumlah'],
                ]);
            }
        } else {
            return redirect('/daftar-menu')
                ->with('warning', 'Bahan tidak boleh kosong!');
        }

        $dataPerPage = 20;
        $data = DB::table('menus')->paginate($dataPerPage);
        $lastPage = $data->lastPage();

        return redirect('/daftar-menu?page=' . $lastPage . '&orderBy=id&direction=asc')
            ->with('success', 'Data "' . $menu->name . '" Berhasil Ditambahkan');
    }

    public function show($slug)
    {
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);

        $menu = Menu::findOrFail($id);

        if ($request->bahan != null) {
            if ($request->has('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                $filename = time() . '.' . $extension;

                $path = 'upload/menu/';
                $file->move($path, $filename);

                $menu->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'image' => $path . $filename,
                ]);
            } else {
                $menu->update([
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
            }

            KomposisiMenu::where('menu_id', $id)->delete();

            foreach ($request->input('bahan', []) as $bahan) {
                KomposisiMenu::create([
                    'menu_id' => $menu->id,
                    'bahan_id' => $bahan['id'],
                    'jumlah' => $bahan['jumlah'],
                ]);
            }
        } else {
            return redirect('/daftar-menu')
                ->with('warning', 'Bahan tidak boleh kosong!');
        }

        return redirect('/daftar-menu')->with('success', 'Menu "' . $request->name . '" berhasil diperbarui');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $barang = Menu::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect('/daftar-menu')->with('success', 'Menu Berhasil Dihapus');
    }
}
