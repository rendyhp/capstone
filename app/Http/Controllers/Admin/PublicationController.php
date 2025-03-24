<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $publications = Publication::latest('updated_at')->whereNull('deleted_at')->get();

        if ($request->ajax()) {
            return datatables()->of($publications)
                ->toJson();
        }

        return view('pages.admin.publication.index');
    }

    public function indexRestore(Request $request)
    {
        $publications = Publication::latest('updated_at')->whereNotNull('deleted_at')->orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            return datatables()->of($publications)
                ->toJson();
        }

        return view('pages.admin.publication.indexRestore');
    }

    public function create()
    {
        return view('pages.admin.publication.create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'data_year' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:10240',
            'file_buku' => 'nullable|mimes:pdf|max:10240',
            'file_lampiran' => 'nullable|mimes:pdf|max:10240',
        ]);

        $user = Auth::user()->id;

        // Penanganan file (pastikan folder upload/publication masih ada)
        $imageName = $this->handleFile($request->image);
        $fpName = $this->handleFile($request->file_buku);
        $flName = $this->handleFile($request->file_lampiran);

        // Simpan data publication ke database
        Publication::create([
            'user_id' => $user,
            'data_year' => $request->data_year,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'file_buku' => $fpName,
            'file_lampiran' => $flName,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Create Publikasi "' . $request->title . '"');


        return redirect()->route('admin.publication')->with('success', 'Publikasi "' . $request->title . '" berhasil ditambahkan');
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
        if ($request->hasFile('file_buku')) {
            $fileFP = $request->file('file_buku');
            $FPName = $fileFP->getClientOriginalName();
            $folder = uniqid('post', true);
            $fileFP->move(public_path('upload/tmp/' . $folder), $FPName);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $FPName
            ]);
            return $folder;
        }
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
        $publications = DB::table('publications')->where('slug', $slug)->first();

        if ($request->has('image')) {
            $fileIMG = $request->image;

            return response()->download(storage_path($fileIMG), null, [], 'inline');
        }
        if ($request->has('file_buku')) {
            $fileFP = $request->file_buku;

            return response()->download(storage_path($fileFP), null, [], 'inline');
        }
        if ($request->has('file_lampiran')) {
            $fileFL = $request->file_lampiran;

            return response()->download(storage_path($fileFL), null, [], 'inline');
        }
    }

    public function tmpDelete()
    {
        $tmp_IMG = TemporaryFile::where('folder', request()->getContent())->first();
        if ($tmp_IMG) {
            File::cleanDirectory(public_path('upload/tmp/' . $tmp_IMG->folder));
            $tmp_IMG->delete();
        }
    }

    // Fungsi handleFile baru
    private function handleFile($file)
    {
        $tmp_file = TemporaryFile::where('folder', $file)->first();
        if ($tmp_file) {
            $fileName = public_path('upload/tmp/' . $tmp_file->folder . '/' . $tmp_file->file);
            $fileContents = file_get_contents($fileName);
            $newFilePath = public_path('upload/publication/' . $tmp_file->file);
            file_put_contents($newFilePath, $fileContents);
            $tmpLocation = 'upload/publication/' . $tmp_file->file;
            File::cleanDirectory(public_path('upload/tmp/' . $tmp_file->folder));
            $tmp_file->delete();

            return $tmpLocation;
        } else {
            return null;
        }
    }

    public function show($slug)
    {
        $publicationsRec = Publication::whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->paginate(6);
        $publications = Publication::where('slug', $slug)->first();
        //return response
        return view('pages.admin.publication.show', [
            'publications' => $publications, 'latestData' => $publicationsRec
        ]);
    }

    public function edit($slug)
    {
        $publications = DB::table('publications')->where('slug', $slug)->first();
        return view('pages.admin.publication.edit', ['data' => $publications]);
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'data_year' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:10240',
            'file_buku' => 'nullable|mimes:pdf|max:10240',
            'file_lampiran' => 'nullable|mimes:pdf|max:10240',
        ]);

        $user = Auth::user()->id;

        // Cari publikasi berdasarkan slug
        $publication = Publication::where('slug', $request->slug)->first();

        // Penanganan file (pastikan folder upload/publication masih ada)
        $imageName = $this->handleFile($request->image);
        $fpName = $this->handleFile($request->file_buku);
        $flName = $this->handleFile($request->file_lampiran);

        // Simpan data publication ke database
        $publication->update([
            'user_id' => $user,
            'data_year' => $request->data_year,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'file_buku' => $fpName,
            'file_lampiran' => $flName,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Update Publikasi "' . $request->title . '"');

        return redirect()->route('admin.publication')
            ->with('update', 'Data publikasi berhasil diperbarui');
    }


    public function delete(Request $request)
    {
        $slug = $request->slug;
        $publication = Publication::where('slug', $slug)->firstOrFail();
        $title = $publication->title;


        $publication->deleted_at = now(); // Tandai data sebagai terhapus sementara
        $publication->save();

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Sementara Publikasi "' . $title . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('update', 'Data publikasi "'  . $title . '" berhasil dihapus sementara');
    }
    public function deletePermanent(Request $request)
    {
        $slug = $request->slug;

        $publication = Publication::where('slug', $slug)->firstOrFail(); 
        $title = $publication->title;
        // Lakukan penghapusan permanen menggunakan Eloquent
        Publication::where('slug', $slug)->forceDelete();
        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Permanen Publikasi "' . $title . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('delete', 'Data publikasi "'  . $title . '" berhasil dihapus permanen');
    }

    public function restore(Request $request)
    {
        $slug = $request->slug;
        $publication = Publication::where('slug', $slug)->firstOrFail(); 
        $title = $publication->title;

        $publication->deleted_at = null;
        $publication->save(); 

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Restore Publikasi "' .  $title . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('success', 'Data publikasi "' .  $title . '" berhasil dikembalikan');
    }
}
