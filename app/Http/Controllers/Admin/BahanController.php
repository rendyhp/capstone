<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkhirTerpakaiSeharusnya;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\HistoryInput;
use App\Models\Satuan;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class BahanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $orderBy = $request->input('orderBy', 'name');
        $direction = $request->input('direction', 'asc');

        $query = Bahan::with('satuan')
            ->whereNull('deleted_at');
        $query->orderBy($orderBy, $direction);

        $satuans = Satuan::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($role === 'OWNER' || $role === 'MANAJER' || $role === 'STAF') {
            $bahans = $query->paginate(20);

            return view('bahan.index', [
                'bahans' => $bahans,
                'satuans' => $satuans
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function indexStok(Request $request)
    {

        $user = Auth::user();
        $role = $user->role;

        $date = $request->input('date', Carbon::today()->toDateString());

        $query = Bahan::with('satuan')->orderBy('name')->whereNull('deleted_at');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $bahans = $query->paginate(20)->appends($request->query());

        foreach ($bahans as $bahan) {
            $bahan->jumlah_awal = BahanAwal::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');
            $bahan->jumlah_masuk = HistoryInput::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');
            $bahan->jumlah_terpakai = AkhirTerpakaiSeharusnya::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');
            $bahan->jumlah_akhir = ($bahan->jumlah_awal + $bahan->jumlah_masuk) - $bahan->jumlah_terpakai;
            $bahan->bahan_akhir = BahanAkhir::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');
            $bahan->bahan_terbuang = ($bahan->jumlah_akhir - $bahan->bahan_akhir);
        }
        if ($role === 'OWNER' || $role === 'MANAJER' || $role === 'STAF') {
            return view('bahan.stokIndex', [

                'bahans' => $bahans,
                'satuans' => Satuan::whereNull('deleted_at')->orderBy('name')->get(),
                'date' => $date,
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexHistory(Request $request, $encryptedId)
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
        $id = $hashids->decode($encryptedId);
        if (empty($id)) {
            abort(404, 'ID tidak valid');
        }

        $user = Auth::user();
        $role = $user->role;

        $bahan = Bahan::with('satuan')->findOrFail($id[0]);
        $query = HistoryInput::with(['bahan.satuan'])
            ->where('bahan_id', $id[0])
            ->whereNull('deleted_at')
            ->orderBy('date', 'desc');

        if ($search = $request->input('search')) {
            $query->whereHas('bahan', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '% ');
            });
        }

        $historyInputs = $query->paginate(20)->appends($request->query());

        $satuans = Satuan::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        if ($role === 'OWNER' || $role === 'MANAJER' || $role === 'STAF') {
            return view('bahan.historyInput', [
                'historyInputs' => $historyInputs,
                'satuans' => $satuans,
                'bahan' => $bahan,
                'encryptedId' => $hashids->encode($id[0]), // Encrypt ID kembali sebelum mengirim ke view
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function inputStore(Request $request)
    {
        $validated = $request->validate([
            'bahan_id' => 'required|string',
            'date' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        try {

            $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
            $decryptedBahanId = $hashids->decode($validated['bahan_id']);

            if (empty($decryptedBahanId)) {
                return redirect()->back()->with('error', 'ID bahan tidak valid.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam dekripsi ID.');
        }

        $bahan = Bahan::find($decryptedBahanId[0]);

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan.');
        }

        HistoryInput::create([
            'user_id' => Auth::id(),
            'bahan_id' => $decryptedBahanId[0],
            'date' => $validated['date'],
            'jumlah' => $validated['jumlah'],
        ]);

        return redirect()->back()->with('success', 'Input stok '. $bahan->name .' pada "' . $validated['date'] . '" berhasil ditambahkan.');
    }

    public function inputUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:history_inputs,id',
            'date' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        try {

            $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
            $decryptedBahanId = $hashids->decode($validated['bahan_id']);

            if (empty($decryptedBahanId)) {
                return redirect()->back()->with('error', 'ID bahan tidak valid.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam dekripsi ID.');
        }

        $bahan = Bahan::find($decryptedBahanId[0]);

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan.');
        }

        try {
            $historyInput = HistoryInput::findOrFail($validated['id']);
            $historyInput->update([
                'date' => $validated['date'],
                'jumlah' => $validated['jumlah'],
            ]);

            return redirect()->back()->with('success', 'Input stok '. $bahan->name .' pada "' . $validated['date'] . '" berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data stok: ' . $e->getMessage());
        }
    }
    public function inputDelete($encryptedId)
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);

        $decoded = $hashids->decode($encryptedId);
        if (empty($decoded)) {
            return redirect()->back()->with('error', 'ID tidak valid.');
        }

        $id = $decoded[0];

        $historyInput = HistoryInput::with('bahan')->findOrFail($id);
        $tanggalDelete = $historyInput->date;
        $historyInput->deleted_at = now();
        $historyInput->save();

        $encryptedBahanId = $hashids->encode($historyInput->bahan_id);
        $jumlahFormatted = rtrim(rtrim(number_format($historyInput->jumlah, 3, ',', '.'), '0'), ',');

        return redirect()->route('stok-bahan.historyBahan', ['encryptedId' => $encryptedBahanId])
            ->with('success', 'Data input '. $historyInput->bahan->name .' pada "' . $tanggalDelete . '" sebesar ' . $jumlahFormatted  .' berhasil dihapus.');
    }

    public function create()
    {

        return view('bahan');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'minimum' => 'required|integer|max:20',
            'satuan_id' => 'required',
        ]);

        try {
            $user = Auth::user()->id;

            $Bahan = new Bahan;
            $Bahan->user_id = $user;
            $Bahan->name = $request->input('name');
            $Bahan->description = $request->input('description' ?: '-');
            $Bahan->minimum = $request->input('minimum' ?: 0);
            $Bahan->satuan_id = $request->input('satuan_id' ?: '-');
            $Bahan->save();

            // Panggil fungsi logAdd() jika diperlukan
            // LogActivity::addToLog('Create Barang "' . $request->input('name') . '"');

            $dataPerPage = 20;
            $data = DB::table('bahans')->paginate($dataPerPage);
            $lastPage = $data->lastPage();

            // Redirect to the data-bahan page with order by id asc
            return redirect('/data-bahan?page=' . $lastPage . '&orderBy=id&direction=asc')
                ->with('success', 'Data "' . $Bahan->name . '" Berhasil Ditambahkan');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                return redirect('data-bahan')->with('error', 'Bahan Gagal Ditambahkan : Nama Bahan yang diinputkan sudah ada');
            } else {
                throw $e; // Rethrow the exception if it's not a unique constraint error
            }
        }
    }


    public function show($slug)
    {

    }

    public function edit(Bahan $bahan)
    {
        $Bahan = Bahan::findOrFail($bahan->id);
        return view('bahan.index', compact('Bahan'));
    }

    public function update(Request $request, Bahan $bahans)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'minimum' => 'required|integer|max:20',
            'satuan_id' => 'required',
        ]);

        try {
            $user = Auth::user()->id;

            $Bahan = Bahan::findOrFail($request->input('id'));

            $Bahan->user_id = $user;
            $Bahan->name = $request->input('name');
            $Bahan->description = $request->input('description' ?: '-');
            $Bahan->minimum = $request->input('minimum' ?: 0);
            $Bahan->satuan_id = $request->input('satuan_id' ?: '-');
            $Bahan->save();

            return redirect('/data-bahan/')->with('success', 'Data Berhasil Diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Bahan sudah ada dalam database.");</script>';
                return redirect('data-bahan')->with('error', 'Bahan Gagal Ditambahkan : Nama Bahan yang diinputkan sudah ada');
            } else {
                throw $e; // Rethrow the exception if it's not due to unique constraint
            }
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $barang = Bahan::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect('/data-bahan')->with('success', 'Data Berhasil Dihapus');
    }

    public function deletePermanent(Request $request)
    {
        $slug = $request->slug;

        $bahans = Bahans::where('slug', $slug)->firstOrFail();
        $name = $bahans->title;
        // Lakukan penghapusan permanen menggunakan Eloquent
        Bahan::where('slug', $slug)->forceDelete();
        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Permanen Bahan "' . $name . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('delete', 'Dataset "' . $name . '" berhasil dihapus permanen');
    }
}
