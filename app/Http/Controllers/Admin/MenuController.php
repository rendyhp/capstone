<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $menus = Menu::orderBy('name', 'asc')
            ->whereNull('deleted_at')
            ->get();

        $komposisiMenus = KomposisiMenu::all();

        if ($request->ajax()) {
            return datatables()->of($menus)->toJson();
        }

        return view('pages.admin.dataset.index', compact('komposisiMenus'));
    }

    public function create()
    {

        return view('pages.admin.dataset.create', compact('tags'));
    }

    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',

            'bahan_id' => 'required',
            'jumlah' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);

        $user = Auth::user()->id;

        // Penanganan file (pastikan folder upload/barang masih ada)
        $imageName = $this->handleFile($request->image);

        // Simpan data dataset ke database
        Menu::create([
            'user_id' => $user,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        KomposisiMenu::create([
            'bahan_id' => $request->bahan_id,
            'jumlah' => $request->jumlah,
            'satuan_id' => $request->satuan_id,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Create Menu "' . $request->name . '"');

        return redirect()->route('admin.dataset')->with('success', 'Barang "' . $request->name . '" berhasil ditambahkan');
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
        $barangs = DB::table('barangs')->where('slug', $slug)->first();

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

    public function edit($slug)
    {
        $barangs = DB::table('menus')->where('slug', $slug)
            ->first();

        return view('pages.admin.dataset.edit', ['barangs' => $barangs]);
    }

    public function update(Request $request, Barangs $barangs)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'jumlah' => 'required',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);

        $user = Auth::user()->id;

        // Cari dataset berdasarkan slug
        $barangs = Barangs::where('slug', $request->slug)->first();

        // Panggil (pastikan folder upload/barang masih ada)
        $imageName = $this->handleFile($request->image);

        // Simpan barang ke database
        $barangs->update([
            'user_id' => $user,
            'name' => $request->name,
            'description' => $request->description,
            'satuan_id' => $request->satuan_id,
            'image' => $imageName,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Update Barang "' . $request->title . '"');

        return redirect()->route('admin.dataset')
            ->with('update', 'Barang berhasil diperbarui');
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
        return Redirect::back()->with('delete', 'Dataset "'  . $name . '" berhasil dihapus permanen');
    }
}
