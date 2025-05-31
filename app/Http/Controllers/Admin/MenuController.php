<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\KomposisiMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        // Cek jika tidak ada bahan
        if (empty($request->bahan)) {
            return redirect()->back()->with('warning', 'Bahan tidak boleh kosong!');
        }
        foreach ($request->bahan as $bahan) {
            if (empty($bahan['id']) || empty($bahan['jumlah'])) {
                return redirect()->back()->with('warning', 'Bahan tidak boleh kosong!');
            }
        }

        $userId = Auth::id();
        $menuData = [
            'user_id' => $userId,
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Simpan file gambar jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'upload/menu/';
            $file->move($path, $filename);
            $menuData['image'] = $path . $filename;
        }

        // Simpan menu
        $menu = Menu::create($menuData);

        foreach ($request->bahan as $bahan) {

            KomposisiMenu::create([
                'menu_id' => $menu->id,
                'bahan_id' => $bahan['id'],
                'jumlah' => $bahan['jumlah'],
            ]);
        }

        $lastPage = DB::table('menus')->paginate(20)->lastPage();

        return redirect('/daftar-menu?page=' . $lastPage . '&orderBy=id&direction=asc')
            ->with('success', 'Data "' . $menu->name . '" berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);

        $menu = Menu::findOrFail($id);

        if (empty($request->bahan)) {
            return redirect()->back()->with('warning', 'Bahan tidak boleh kosong!');
        }
        foreach ($request->bahan as $bahan) {
            if (empty($bahan['id']) || empty($bahan['jumlah'])) {
                return redirect()->back()->with('warning', 'Bahan tidak boleh kosong!');
            }
        }


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

        return redirect()->back()->with('success', 'Menu "' . $request->name . '" berhasil diperbarui');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $menu = Menu::findOrFail($id);

        $menuName = $menu->name;
        $menu->deleted_at = now();
        $menu->save();

        return redirect()->back()->with('success', 'Menu "' . $menuName . '" Berhasil Dihapus');
    }

    public function deleteImageMenu($id)
    {
        $barang = Menu::findOrFail($id);

        if ($barang->image && file_exists(public_path($barang->image))) {
            unlink(public_path($barang->image)); // Hapus dari folder
        }

        $barang->image = null; // Kosongkan di database
        $barang->save();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }

}
