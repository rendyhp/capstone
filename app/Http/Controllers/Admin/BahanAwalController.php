<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\BahanAwal;
use App\Models\Barang;

use App\Models\SatuanBahan;
use Carbon\Carbon;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class BahanAwalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role !== 'OWNER') {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $date = $request->input('date', Carbon::today()->toDateString());
        $search = $request->input('search');

        // Query join BahanAwal -> Bahan -> Satuan
        $query = BahanAwal::selectRaw('
            bahan_awals.bahan_id,
            SUM(bahan_awals.jumlah) as stok,
            MAX(bahan_awals.date) as tanggal,
            bahans.name as bahan_name,
            satuan_bahans.name as satuan_name
        ')
            ->join('bahans', 'bahan_awals.bahan_id', '=', 'bahans.id')
            ->join('satuan_bahans', 'bahans.satuan_id', '=', 'satuan_bahans.id')
            ->whereNull('bahan_awals.deleted_at')
            ->whereNull('bahans.deleted_at')
            ->whereDate('bahan_awals.date', $date)
            ->when($search, function ($q) use ($search) {
                $q->where('bahans.name', 'like', '%' . $search . '%');
            })
            ->groupBy('bahan_awals.bahan_id', 'bahans.name', 'satuan_bahans.name')
            ->orderBy('bahans.name', 'asc');

        $allData = $query->get();

        // Ambil data terbaru untuk tiap bahan_id
        $grouped = $allData->groupBy('bahan_id')->map(function ($items) {
            return $items->first();
        })->values();

        // Pagination manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentItems = $grouped->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $bahanAwalAwals = new LengthAwarePaginator($currentItems, $grouped->count(), $perPage);
        $bahanAwalAwals->appends($request->query());


        $satuans = SatuanBahan::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        $bahans = Bahan::whereNull('deleted_at')->with('satuan')->orderBy('name', 'asc')->get();

        return view('bahan.indexBahanAwal', [
            'bahanAwalAwals' => $bahanAwalAwals,
            'satuans' => $satuans,
            'bahans' => $bahans,
            'date' => $date,
        ]);
    }




    public function create()
    {

        return view('pages.admin.dataset.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Validate input fields
        $request->validate([
            'date' => 'required|date',
            'bahan_awal.*.bahan_id' => 'required|exists:bahans,id',
            'bahan_awal.*.jumlah' => 'required|numeric|min:0.001',
        ]);

        // Check if bahan_awal is provided and is not empty
        if (empty($request->bahan_awal) || !is_array($request->bahan_awal)) {
            return redirect()->route('bahan-awal.index', ['date' => $request->date])
                ->with('error', 'Bahan awal tidak dapat kosong.');

        }

        // Process each item in bahan_awal
        foreach ($request->bahan_awal as $item) {
            BahanAwal::create([
                'user_id' => $user,
                'date' => $request->date,
                'bahan_id' => $item['bahan_id'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return redirect()->route('bahan-awal.index', ['date' => $request->date])
            ->with('success', 'Bahan awal berhasil disimpan.');
    }


    public function edit($bahan_id, Request $request)
    {
        $date = $request->input('date');
        $entries = BahanAwal::where('bahan_id', $bahan_id)
            ->whereDate('date', $date)
            ->get();

        $bahan = Bahan::with('satuan')->find($bahan_id);

        return response()->json([
            'entries' => $entries,
            'bahan' => $bahan,
            'date' => $date,
        ]);
    }



    public function update($bahan_id, Request $request)
    {
        $request->validate([
            'jumlah.*' => 'required|numeric|min:0.001',
            'date' => 'required|date',
        ]);

        $jumlahs = $request->input('jumlah');
        $date = $request->input('date');

        DB::transaction(function () use ($jumlahs, $bahan_id, $date) {
            // Jika semua jumlah bahan dihapus (jumlahnya kosong)
            if (empty($jumlahs) || $this->allItemsAreEmpty($jumlahs)) {
                // Hapus semua entri untuk bahan_id dan tanggal yang diberikan
                BahanAwal::where('bahan_id', $bahan_id)
                    ->whereDate('date', $date)
                    ->delete();
            } else {
                // Jika ada jumlah yang diinputkan, lakukan update/insert
                // Hapus semua entri yang ada untuk bahan_id dan tanggal yang diberikan
                BahanAwal::where('bahan_id', $bahan_id)
                    ->whereDate('date', $date)
                    ->delete();

                // Insert entri baru untuk jumlah yang diberikan
                foreach ($jumlahs as $jumlah) {
                    BahanAwal::create([
                        'bahan_id' => $bahan_id,
                        'jumlah' => $jumlah,
                        'date' => $date,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Data bahan awal berhasil diperbarui.');
    }

    // Fungsi untuk memeriksa apakah semua item dalam array kosong
    private function allItemsAreEmpty($items)
    {
        return count(array_filter($items, function ($value) {
            return !empty($value); // Memastikan ada nilai yang tidak kosong
        })) === 0;
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




    public function delete(Request $request)
    {
        $bahan_id = $request->input('bahan_id');
        $date = $request->input('date', Carbon::today()->toDateString());

        BahanAwal::where('bahan_id', $bahan_id)
            ->whereDate('date', $date)
            ->update(['deleted_at' => now()]);

        return redirect()->route('stok-bahan-awal', ['date' => $date])
            ->with('success', 'Data bahan berhasil dihapus.');
    }




}
