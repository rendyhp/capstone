<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dataset;
use App\Models\Tag;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class DatasetController extends Controller
{
    public function index(Request $request)
    {
        $datasets = Dataset::latest('updated_at')->whereNull('deleted_at')
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->get();

        if ($request->ajax()) {
            return datatables()->of($datasets)->toJson();
        }

        return view('pages.admin.dataset.index');
    }


    public function indexRestore(Request $request)
    {
        $datasets = Dataset::latest('updated_at')->whereNotNull('deleted_at')
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->get();

        if ($request->ajax()) {
            return datatables()->of($datasets)->toJson();
        }

        return view('pages.admin.dataset.indexRestore');
    }

    public function indexTag(Request $request)
    {
        $tags = Tag::latest('updated_at')->get();
        if ($request->ajax()) {
            return datatables()->of($tags)->toJson();
        }

        return view('pages.admin.dataset.tag.index');
    }

    public function tagCreate()
    {
        return view('pages.admin.dataset.tag.create');
    }

    public function tagStore(Request $request)
    {
        Validator::make($request->all(), [
            'tag' => 'required',
            'definition' => 'required',
        ]);

        $user = Auth::user()->id;

        // Simpan data dataset ke database
        Tag::create([
            'user_id' => $user,
            'tag' => $request->tag,
            'definition' => $request->definition,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Create Tag "' . $request->tag . '"');

        return redirect()->route('admin.datasetTag')->with('success', 'Tag "' . $request->tag . '" berhasil ditambahkan');
    }

    public function create()
    {
        $tags = Tag::all();

        return view('pages.admin.dataset.create', compact('tags'));
    }

    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'data_year' => 'required',
            'title' => 'required',
            'description' => 'required',
            'tag_id' => 'required',
            'file_lampiran' => 'nullable|mimes:pdf|max:10240',
        ]);

        $user = Auth::user()->id;

        // Penanganan file (pastikan folder upload/dataset masih ada)
        $flName = $this->handleFile($request->file_lampiran);

        // Simpan data dataset ke database
        Dataset::create([
            'user_id' => $user,
            'data_year' => $request->data_year,
            'title' => $request->title,
            'description' => $request->description,
            'tag_id' => $request->tag_id,
            'file_lampiran' => $flName,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Create Dataset "' . $request->title . '"');

        return redirect()->route('admin.dataset')->with('success', 'Dataset "' . $request->title . '" berhasil ditambahkan');
    }

    public function tmpUpload(Request $request)
    {
        if ($request->hasFile('file_lampiran')) {
            $fileFL = $request->file('file_lampiran');
            $FLName = $fileFL->getClientOriginalName();
            $folder = uniqid('post', true);
            $fileFL->move(public_path('upload/tmp/' . $folder), $FLName);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $FLName
            ]);
            return $folder;
        }

        return '';
    }

    public function tmpLoad(Request $request, $slug)
    {
        // Temukan file sesuai fileId (atau nama file)
        $datasets = DB::table('datasets')->where('slug', $slug)->first();

        if ($request->has('file_lampiran')) {
            $fileFL = $request->file_lampiran;

            return response()->download(storage_path($fileFL), null, [], 'inline');
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

    private function handleFile($file)
    {
        $tmp_file = TemporaryFile::where('folder', $file)->first();
        if ($tmp_file) {
            $fileName = public_path('upload/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
            $fileContents = file_get_contents($fileName);
            $newFilePath = public_path('upload/dataset/' . $tmp_file->file);
            file_put_contents($newFilePath, $fileContents);
            $tmpLocation = 'upload/dataset/' . $tmp_file->file;
            File::cleanDirectory(public_path('upload/tmp/' . $tmp_file->folder));
            $tmp_file->delete();

            return $tmpLocation;
        } else {
            return null;
        }
    }

    // Fungsi untuk menangani file
    // private function handleFile($request, $fileName)
    // {
    //     if ($request->hasFile($fileName)) {
    //         $file = $request->file($fileName);
    //         $fileName = $file->getClientOriginalName();
    //         $file->move(public_path('upload/dataset/'), $fileName);
    //         $dt = ('upload/dataset/') . $fileName;
    //         return $dt;
    //     } else {
    //         return null;
    //     }
    // }

    public function show($slug)
    {
        $datasetsRec = Dataset::whereNull('deleted_at')
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->orderBy('updated_at', 'desc')
            ->paginate(6);

        $datasets = Dataset::where('slug', $slug)
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->first();

            return view('pages.admin.dataset.show', [
                'datasets' => $datasets, 'latestData' => $datasetsRec
            ]);
    }

    public function edit($slug)
    {
        $datasets = DB::table('datasets')->where('slug', $slug)
            ->join('tags', 'datasets.tag_id', '=', 'tags.id')
            ->select('datasets.*', 'tags.tag', 'tags.definition')
            ->first();

        $tags = Tag::all();

        return view('pages.admin.dataset.edit', ['datasets' => $datasets, 'tags' => $tags]);
    }

    public function update(Request $request, Dataset $datasets)
    {
        Validator::make($request->all(), [
            'data_year' => 'required',
            'title' => 'required',
            'description' => 'required',
            'tag_id' => 'required',
            'file_lampiran' => 'nullable|mimes:pdf|max:10240',
        ]);

        $user = Auth::user()->id;

        // Cari dataset berdasarkan slug
        $datasets = Dataset::where('slug', $request->slug)->first();

        // Panggil (pastikan folder upload/dataset masih ada)
        $flName = $this->handleFile($request->file_lampiran);

        // Simpan dataset ke database
        $datasets->update([
            'user_id' => $user,
            'data_year' => $request->data_year,
            'title' => $request->title,
            'description' => $request->description,
            'tag_id' => $request->tag_id,
            'file_lampiran' => $flName,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Update Dataset "' . $request->title . '"');

        return redirect()->route('admin.dataset')
            ->with('update', 'Dataset berhasil diperbarui');
    }

    public function delete(Request $request)
    {
        $slug = $request->slug;
        $dataset = Dataset::where('slug', $slug)->firstOrFail();
        $title = $dataset->title;

        $dataset->deleted_at = now();
        $dataset->save();

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Sementara Dataset "' . $title . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('update', 'Dataset "'  . $title . '" berhasil dihapus sementara');
    }

    public function deletePermanent(Request $request)
    {
        $slug = $request->slug;

        $dataset = Dataset::where('slug', $slug)->firstOrFail();
        $title = $dataset->title;
        // Lakukan penghapusan permanen menggunakan Eloquent
        Dataset::where('slug', $slug)->forceDelete();
        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Permanen Dataset "' . $title . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('delete', 'Dataset "'  . $title . '" berhasil dihapus permanen');
    }

    public function restore(Request $request)
    {
        $slug = $request->slug;
        $dataset = Dataset::where('slug', $slug)->firstOrFail();
        $title = $dataset->title;

        $dataset->deleted_at = null;
        $dataset->save();

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Restore Dataset "' . $title . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('success', 'Dataset "' .  $title . '" berhasil dikembalikan');
    }
}
