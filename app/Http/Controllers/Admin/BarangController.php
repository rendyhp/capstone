<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\SatuanBarang;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = Barang::select('barangs.*')
        ->join('satuan_barangs', 'barangs.satuan_id', '=', 'satuan_barangs.id')
        ->whereNull('barangs.deleted_at')
        ->orderBy('name', 'asc');

        if ($search = $request->input('search')) {
            $query->where('barangs.name', 'like', '%' . $search . '%');
        }

        $query->orderBy('barangs.name', 'asc');
        $satuanBarangs = SatuanBarang::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        // Paginate hasil query
        $barangs = $query->paginate(20)->appends($request->query());

        

        // Cek role pengguna dan tampilkan view yang sesuai
        if ($role === 'OWNER') {
            return view('barang.index', compact('barangs', 'satuanBarangs'));
        } elseif ($role === 'user') {
            return view('user.barang', compact('barangs', 'satuanBarangs'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function create()
    {

        return view('barang');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'description' => 'nullable|string',
            'jumlah' => 'required|integer|max:20',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);

        try {
            $user = Auth::user()->id;

            // Penanganan file (pastikan folder upload/barang masih ada)
            $imageName = $this->handleFile($request->image);

            $Barang = new Barang;
            $Barang->user_id = $user;
            $Barang->name = $request->input('name');
            $Barang->description = $request->input('description' ?: '-');
            $Barang->jumlah = $request->input('jumlah' ?: 0);
            $Barang->satuan_id = $request->input('satuan_id' ?: '-');
            $Barang->image = $request->input('image') ?: null;
            $Barang->save();

            // Panggil fungsi logAdd()
            // LogActivity::addToLog('Create Barang "' . $request->input('name') . '"');

            $dataPerPage = 20;
            $data = DB::table('barangs')->paginate($dataPerPage);
            $lastPage = $data->lastPage();
            return redirect('/stok-barang?page=' . $lastPage)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Barang sudah ada dalam database.");</script>';
                return redirect('stok-barang')->with('error', 'Barang Gagal Ditambahkan : Nama Barang yang diinputkan sudah ada');
            } else {
                throw $e; // Rethrow the exception if it's not due to unique constraint
            }
        }
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
            $newFilePath = public_path('upload/img/barang/' . $tmp_file->file);
            file_put_contents($newFilePath, $fileContents);
            $tmpLocation = 'upload/publication/' . $tmp_file->file;
            File::cleanDirectory(public_path('upload/tmp/' . $tmp_file->folder));
            $tmp_file->delete();

            return $tmpLocation;
        } else {
            return null;
        }
    }

    public function show($id)
    {
        
    }

    public function edit(Barang $barang)
    {
        $Barang = Barang::findOrFail($barang->id);
        return view('barang.index', compact('Barang'));
    }

    public function update(Request $request, Barang $barangs)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'jumlah' => 'required|integer|max:10',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);

        try {
            $user = Auth::user()->id;

            $Barang = Barang::findOrFail($request->input('id'));
            $Barang->user_id = $user;
            $Barang->name = $request->input('name');
            $Barang->description = $request->input('description' ?: '-');
            $Barang->jumlah = $request->input('jumlah' ?: 0);
            $Barang->satuan_id = $request->input('satuan_id' ?: '-');
            $Barang->image = $request->input('image') ?: null;
            $Barang->save();

            return redirect('/stok-barang')->with('success', 'Data "' . $Barang->name . '" Berhasil Diubah');

        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Barang sudah ada dalam database.");</script>';
                return redirect('stok-barang')->with('error', 'Barang "' . $Barang->name . '" Gagal Diubah');
            } else {
                throw $e;
            }
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $barang = Barang::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect('/stok-barang')->with('success', 'Data Berhasil Dihapus');
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
