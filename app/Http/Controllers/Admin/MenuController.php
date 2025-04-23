<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Barang;
use App\Models\KomposisiMenu;
use App\Models\Menu;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // Ambil parameter sorting dari URL atau pakai default
        $orderBy = $request->input('orderBy', 'name');
        $direction = $request->input('direction', 'asc');

        // Ambil data bahan untuk komposisi
        $bahans = Bahan::whereNull('deleted_at')->orderBy('name', 'asc')->get();

        // Siapkan query untuk daftar menu
        $query = Menu::with('komposisi.bahan.satuan')
            ->whereNull('deleted_at');

        // Filter pencarian jika ada
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Urutkan berdasarkan parameter dari URL
        $query->orderBy($orderBy, $direction);

        // Pagination dan pengembalian view hanya jika rolenya cocok
        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            $menus = $query->paginate(20)->withQueryString(); // biar pagination tetap bawa query parameter

            return view('daftar-menu.index', [
                'menus' => $menus,
                'bahans' => $bahans
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function create()
    {

        return view('menu');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);
        $user = Auth::user()->id;

        // Penanganan file (pastikan folder upload/barang masih ada)
        $imageName = $this->handleFile($request->image);

        $menu = Menu::create([
            'user_id' => $user,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $this->handleFile($request->image),
        ]);
        // Simpan data dataset ke database
        foreach ($request->bahan as $bahan) {
            KomposisiMenu::create([
                'menu_id' => $menu->id,
                'bahan_id' => $bahan['id'],
                'jumlah' => $bahan['jumlah'],
            ]);
        }

        $dataPerPage = 20;
        $data = DB::table('menus')->paginate($dataPerPage);
        $lastPage = $data->lastPage();

        return redirect('/daftar-menu?page=' . $lastPage . '&orderBy=id&direction=asc')
            ->with('success', 'Data "' . $menu->name . '" Berhasil Ditambahkan');

    }

    public function tmpUpload(Request $request)
    {
        if ($request->hasFile('image')) {
            $fileIMG = $request->file('image');
            $imageName = $fileIMG->getClientOriginalName();
            $folder = uniqid('post', true);
            $fileIMG->move(public_path('upload/tmp/' . $folder), $imageName);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $imageName
            ]);
            return $folder;
        }

        return '';
    }

    public function tmpLoad(Request $request, $slug)
    {
        // Temukan file sesuai fileId (atau nama file)
        $menus = DB::table('menus')->where('slug', $slug)->first();

        if ($request->has('image')) {
            $fileIMG = $request->image;

            return response()->download(storage_path($fileIMG), null, [], 'inline');
        }
    }

    public function tmpDelete()
    {
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
        if ($tmp_file) {
            File::cleanDirectory(public_path('upload/tmp/' . $tmp_file->folder));
            $tmp_file->delete();
        }
    }

    // Fungsi handleFile baru
    private function handleFile($file)
    {
        $tmp_file = TemporaryFile::where('folder', $file)->first();
        if ($tmp_file) {
            $fileName = public_path('upload/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
            $fileContents = file_get_contents($fileName);
            $newFilePath = public_path('upload/menu/' . $tmp_file->file);
            file_put_contents($newFilePath, $fileContents);
            $tmpLocation = 'upload/menu/' . $tmp_file->file;
            File::cleanDirectory(public_path('upload/tmp/' . $tmp_file->folder));
            $tmp_file->delete();

            return $tmpLocation;
        } else {
            return null;
        }
    }

    public function show($slug)
    {
        $menus = Dataset::where('slug', $slug)
            ->first();

        return view('pages.admin.dataset.show', [
            'menus' => $menus,
        ]);
    }

    public function edit(KomposisiMenu $menu)
    {

        return view('daftar-menu.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);

        $menu = Menu::findOrFail($id);

        // Penanganan file (jika ada gambar baru)

        // Update data menu
        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Update komposisi menu
        KomposisiMenu::where('menu_id', $id)->delete(); // Hapus komposisi lama

        foreach ($request->input('bahan', []) as $bahan) {
            KomposisiMenu::create([
                'menu_id' => $menu->id,
                'bahan_id' => $bahan['id'],
                'jumlah' => $bahan['jumlah'],
            ]);
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

    public function deletePermanent(Request $request)
    {
        $slug = $request->slug;

        $barang = Barangs::where('slug', $slug)->firstOrFail();
        $name = $barang->title;
        // Lakukan penghapusan permanen menggunakan Eloquent
        Barang::where('slug', $slug)->forceDelete();
        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Permanen Barang "' . $name . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('delete', 'Dataset "' . $name . '" berhasil dihapus permanen');
    }
}
