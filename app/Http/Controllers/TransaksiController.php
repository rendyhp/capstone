<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\View\View;
use App\Models\UP;
use App\Models\ULP;
use App\Models\User;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index(Request $request) : View
    {
        $user = Auth::user();
        $role = $user->role;
        $unit = $user->unit;
        $query = Transaksi::query();

        if($role === 'admin'){

            $search = $request->input('search');
        
            $query->when($unit != '13000', function ($query) use ($unit) {
                $allowedUnits = ['UP3 Padang', 'UP3 Solok', 'UP3 Bukittinggi', 'UP3 Payakumbuh'];
                return $query->whereHas('up', function ($subquery) use ($unit, $allowedUnits) {
                    $subquery->where('up_id', $unit)->orWhereIn('up_id', $allowedUnits);
                });
            });

            if ($search) {
                $query->where('ulp_nama', 'like', '%' . $search . '%');
            }

            $transaksis = $query->paginate(8);
          
            $users = User::find($unit);
            $UPs = UP::all();
            $ULPs = ULP::all();

            return view('transaksi.index', compact('transaksis', 'UPs', 'ULPs','users'));
        }
        else if($role === 'user'){

            $search = $request->input('search');
        
            $query->when($unit != '13000', function ($query) use ($unit) {
                $allowedUnits = ['UP3 Padang', 'UP3 Solok', 'UP3 Bukittinggi', 'UP3 Payakumbuh'];
                return $query->whereHas('up', function ($subquery) use ($unit, $allowedUnits) {
                    $subquery->where('up_id', $unit)->orWhereIn('up_id', $allowedUnits);
                });
            });

            $query->where('created_by', auth()->user()->id);
            
            if ($search) {
                $query->where('ulp_nama', 'like', '%' . $search . '%');
            }

            $transaksis = $query->paginate(8);
            if ($unit === '13000') {
                foreach ($transaksis as $transaksi) {
                    if ($transaksi->jenis_transaksi === 'Keluar') {
                        $transaksi->jenis_transaksi = 'Masuk';
                    }
                }
            }
            $users = User::find($unit);
            $UPs = UP::all();
            $ULPs = ULP::all();
        
            return view('user.riwayat', compact('transaksis', 'UPs', 'ULPs', 'users'));
        }
        else{
            return abort(403,'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

    }
    public function trans(){

        return view('user.beranda');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function input() : View
    {
        $UPs = UP::all();
        $ULPs = ULP::all();

        return view('transaksi.input', compact('UPs', 'ULPs'));

    }
    public function caribarangmasuk(Request $request)
    {
        $carimasuk = $request->input('cari');
        $Barangs = [];
        
        if (!empty($carimasuk)) {
            $Barangs = Barang::where('barang_code', 'like', '%' . $carimasuk . '%')
                ->orWhere('barang_nama', 'like', '%' . $carimasuk . '%')
                ->orWhere('barang_merk', 'like', '%' . $carimasuk .'%')->first();
    
            if ($Barangs) {
                $barang_code = $Barangs['barang_code'];
                $barang_nama = $Barangs['barang_nama'];
                $barang_merk = $Barangs['barang_merk'];
                $barang_jenis = $Barangs['barang_jenis'];
                $barang_tipe = $Barangs['barang_tipe'];
                $barang_satuan = $Barangs['barang_satuan'];
                $html = "<tr>
                            <td><input type='text' hidden class='form-control' value='$barang_code'  name='barang_code[]'>$barang_code</td>
                            <td>$barang_nama</td>
                            <td>$barang_merk</td>
                            <td>$barang_jenis</td>
                            <td>$barang_tipe</td>
                            <td>$barang_satuan</td>
                            <td><input type='number' class='form-control' name='barang_quantity[]'></td>
                            <td><input type='text' class='form-control' name='barang_sn[]'></td>
                            <td><input type='text' class='form-control' name='status[]'></td>
                            <td><input type='text' class='form-control' name='keterangan[]'></td>
                            <td><button class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true' onclick='deleteRow(this)'></i></button></td>
                        </tr>";
                echo $html;
            }else {
                // Jika data tidak ditemukan, kirimkan pesan 'Tidak ada hasil yang ditemukan'
                echo json_encode('Tidak ada hasil yang ditemukan');
            }
        } else {
            // Jika pencarian kosong, kirimkan pesan 'Pencarian kosong'
            echo json_encode(['kosong' => 'Pencarian kosong']);
        }
    }

    public function destroy(Transaksi $transaksi)
    {
            $user = Auth::user()->name;
            $role = Auth::user()->role;

            if ($role === 'admin') {

                Transaksi::destroy($transaksi->id);
                return redirect('/transaksi')->with('success', 'Data berhasil dihapus.');

            } elseif (auth()->user()->id == $transaksi->created_by) {

                Transaksi::destroy($transaksi->id);
                return redirect('/transaksi')->with('success', 'Data berhasil dihapus.');
            } else {
                return redirect('/transaksi')->with('error', 'Anda tidak memiliki hak akses untuk menghapus data ini.');
            }
    }

    public function simpanDataMasuk(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggaltransmasuk' => 'required|date',
            'slcupmasuk' => 'required|exists:up,id',
            'slculpmasuk' => 'nullable|exists:ulp,id',
            'barang_code.*' => 'required|exists:barang,barang_code',
            'barang_quantity.*' => 'nullable|integer|min:1',
            'barang_sn.*' => 'nullable|string|max:255',
            'status.*' => 'nullable|string|max:255',
            'keterangan.*' => 'nullable|string|max:255'

        ], [
            'tanggaltransmasuk.required' => 'Tanggal transaksi harus diisi.',
            'tanggaltransmasuk.date' => 'Tanggal transaksi harus berupa tanggal yang valid.',
            'slcupmasuk.required' => 'Pilih UP terlebih dahulu.',
            'slcupmasuk.exists' => 'UP yang Anda pilih tidak valid.',
            'slculpmasuk.required' => 'Pilih ULP terlebih dahulu.',
            'slculpmasuk.exists' => 'ULP yang Anda pilih tidak valid.',
            'barang_code.*.required' => 'Kode barang wajib diisi.',
            'barang_code.*.exists' => 'Kode barang tidak valid.',
            'barang_quantity.*.required' => 'Quantity barang wajib diisi.',
            'barang_quantity.*.integer' => 'Quantity barang harus berupa angka.',
            'barang_quantity.*.min' => 'Quantity barang harus lebih dari atau sama dengan 1.',
            'barang_sn.*.max' => 'Serial number barang tidak boleh lebih dari :max karakter.',
            'keterangan.*.max' => 'Keterangan tidak boleh lebih dari :max karakter.'

        ]);

        if ($validator->fails()) {
            return redirect('/transaksi')
                ->withErrors($validator)
                ->withInput();
        }
        $kodeTrans = Transaksi::generateTransaksi('masuk'); 
        try {
            // Buat transaksi baru
            $transaksi = new Transaksi;
            $transaksi -> kode_trans = $kodeTrans;
            $transaksi->tanggal_trans = $request->input('tanggaltransmasuk');
            $transaksi->up_id = $request->input('slcupmasuk');
            $transaksi->ulp_id = $request->input('slculpmasuk');
            $transaksi->created_by = auth()->user()->id;
            $transaksi->created_at = now();
            $transaksi->save();

            // Mendapatkan ID transaksi yang baru saja disimpan
            $transaksiId = $transaksi->id;

            // Mendapatkan data barang yang dikirim dari form
            $barangCodes = $request->input('barang_code');
            $barangQuantities = $request->input('barang_quantity');
            $barangSns = $request->input('barang_sn');
            $Status = $request->input('status');
            $Ket = $request->input('keterangan');


            // Loop melalui data barang dan menyimpan detail transaksi
            for ($i = 0; $i < count($barangCodes); $i++) {
                // Cari barang berdasarkan barang_code
                $barang = Barang::where('barang_code', $barangCodes[$i])->first();

                if ($barang) {
                    $detailTransaksi = new DetailTransaksi;
                    $detailTransaksi->trans_id = $transaksiId;
                    $detailTransaksi->barang_id = $barang->id; // Menggunakan barang_id yang sesuai
                    $detailTransaksi->barang_quantity = $barangQuantities[$i];
                    $detailTransaksi->barang_sn = $barangSns[$i];
                    $detailTransaksi->status = $Status[$i];
                    $detailTransaksi->keterangan = $Ket[$i];
                    $detailTransaksi->save();
                } else {
                    // Barang dengan barang_code tertentu tidak ditemukan, Anda bisa menangani ini sesuai kebutuhan Anda
                    // Misalnya, Anda bisa melewatkan data ini atau memberikan pesan kesalahan.
                }
            }

            return redirect('/transaksi')->with('success', 'Transaksi berhasil disimpan');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                return redirect('/transaksi')->with('error', 'Transaksi Gagal: Barang sudah ada dalam database');
            } else {
                throw $e; // Rethrow the exception if it's not due to unique constraint
            }
        }
    } 
    public function autocomplete(Request $request)
    {
        $cari = $request->input('cari');

        // $results = Barang::where('barang_code', 'LIKE', "%$cari%")
        //                 ->orWhere('barang_nama', 'LIKE', "%$cari%")
        //                 ->get();
        $results = Barang::select('barang_nama')
                            ->groupBy('barang_nama')
                            ->get();
        return response()->json($results);
    }
    public function detail($transaksi_id){
        $user = Auth::user();
        $role = $user->role;

        if($role === 'admin'){
            $transaksis = Transaksi::all();

            $detailtransaksis = DetailTransaksi::with('transaksi')->where('trans_id', $transaksi_id)->get();
            return view('detailtransaksi', compact('transaksis','detailtransaksis'));
        }else if($role === 'user'){
            $transaksis = Transaksi::all();

            $detailtransaksis = DetailTransaksi::with('transaksi')->where('trans_id', $transaksi_id)->get();
            return view('user.detail', compact('transaksis','detailtransaksis'));
        }
    }
    public function keluar() : View
    {
        $user = Auth::user();
        $role = $user->role;

        if($role === 'admin'){
            $UPs = UP::all();
            $ULPs = ULP::all();

            return view('transaksi.keluar',compact('UPs','ULPs'));
        }else if ($role === 'user'){
            $UPs = UP::all();
            $ULPs = ULP::all();

            return view('user.transaksi',compact('UPs','ULPs'));
        } else{
            return abort(403,'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
    public function caribarangkeluar(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if($role ==='admin'){
            $carikeluar = $request->input('cari');
            
            if (!empty($carikeluar)) {
                // Cari data barang yang sesuai dengan pencarian
                $Barangs = Barang::where('barang_code', 'like', '%' . $carikeluar . '%')
                    ->orWhere('barang_nama', 'like', '%' . $carikeluar .'%')
                    ->orWhere('barang_merk', 'like', '%' . $carikeluar .'%')->first();
            
                if ($Barangs) {
                    // Mengambil jumlah stok masuk
                    $jumlahStokMasuk = DetailTransaksi::where('barang_id', $Barangs->id)
                        ->whereHas('transaksi', function ($query) {
                            $query->where('trans_jenis', 'masuk');
                        })
                        ->sum('barang_quantity');
                    
                    // Mengambil jumlah stok keluar
                    $jumlahStokKeluar = DetailTransaksi::where('barang_id', $Barangs->id)
                        ->whereHas('transaksi', function ($query) {
                            $query->where('trans_jenis', 'keluar');
                        })
                        ->sum('barang_quantity');

                    $detail = DetailTransaksi::where('barang_id', $Barangs->id)
                        ->whereHas('transaksi', function ($query) {
                            $query->where('trans_jenis', 'masuk');
                        })->first();
                    
                    //Menggunakan selisih stok masuk dan keluar
                    $barang_code = $Barangs->barang_code;
                    $barang_nama = $Barangs->barang_nama;
                    $barang_merk = $Barangs->barang_merk;
                    $barang_jenis = $Barangs->barang_jenis;
                    $barang_tipe = $Barangs->barang_tipe;
                    $barang_satuan = $Barangs->barang_satuan;
                    $stock = $jumlahStokMasuk - $jumlahStokKeluar;
                    $status = $detail -> status;
                    $ket = $detail-> keterangan;

                    
                    if($stock >= 0){
                        if($stock==0){
                            $dis = "readonly";
                        }else{
                            $dis = "";
                        }
                        $html = "<tr>
                                    <td><input type='text' hidden class='form-control' value='$barang_code' name='barang_code[]'>$barang_code</td>
                                    <td>$barang_nama</td>
                                    <td>$barang_merk</td>
                                    <td>$barang_jenis</td>
                                    <td>$barang_tipe</td>
                                    <td>$barang_satuan</td>
                                    <td class='tdStock'>$stock</td>
                                    <td><input type='number' $dis class='form-control' name='barang_quantity[]' min='1' max='$stock'></td>
                                    <td><input type='text' $dis class='form-control' name='barang_sn[]'></td>
                                    <td>$status</td>
                                    <td>$ket</td>
                                    <td><button class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true' onclick='deleteRow(this)'></i></button></td>
                                </tr>";
                        echo $html;
                    }else{

                    }
                } else {
                    // Jika data barang tidak ditemukan, kirimkan pesan 'Tidak ada hasil yang ditemukan'
                    echo json_encode('Tidak ada hasil yang ditemukan');
                }
            }
        }else if($role ==='user'){
            $carikeluar = $request->input('cari');
            
            if (!empty($carikeluar)) {
                // Cari data barang yang sesuai dengan pencarian
                $Barangs = Barang::where('barang_code', 'like', '%' . $carikeluar . '%')
                    ->orWhere('barang_nama', 'like', '%' . $carikeluar .'%')
                    ->orWhere('barang_merk', 'like', '%' . $carikeluar .'%')->first();
            
                if ($Barangs) {
                    // Mengambil jumlah stok masuk
                    $jumlahStokMasuk = DetailTransaksi::where('barang_id', $Barangs->id)
                        ->whereHas('transaksi', function ($query) {
                            $query->where('trans_jenis', 'masuk');
                        })
                        ->sum('barang_quantity');
                    
                    // Mengambil jumlah stok keluar
                    $jumlahStokKeluar = DetailTransaksi::where('barang_id', $Barangs->id)
                        ->whereHas('transaksi', function ($query) {
                            $query->where('trans_jenis', 'keluar');
                        })
                        ->sum('barang_quantity');

                    $detail = DetailTransaksi::where('barang_id', $Barangs->id)
                        ->whereHas('transaksi', function ($query) {
                            $query->where('trans_jenis', 'masuk');
                        })->first();
                    
                    //Menggunakan selisih stok masuk dan keluar
                    $barang_code = $Barangs->barang_code;
                    $barang_nama = $Barangs->barang_nama;
                    $barang_merk = $Barangs->barang_merk;
                    $barang_jenis = $Barangs->barang_jenis;
                    $barang_tipe = $Barangs->barang_tipe;
                    $barang_satuan = $Barangs->barang_satuan;
                    $stock = $jumlahStokMasuk - $jumlahStokKeluar;
                    $status = $detail -> status;
                    $ket = $detail-> keterangan;

                    
                    if($stock >= 0){
                        if($stock==0){
                            $dis = "readonly";
                        }else{
                            $dis = "";
                        }
                        $html = "<tr>
                                    <td><input type='text' hidden class='form-control' value='$barang_code' name='barang_code[]'>$barang_code</td>
                                    <td>$barang_nama</td>
                                    <td>$barang_merk</td>
                                    <td>$barang_jenis</td>
                                    <td>$barang_tipe</td>
                                    <td>$barang_satuan</td>
                                    <td class='tdStock'>$stock</td>
                                    <td><input type='number' $dis class='form-control' name='barang_quantity[]' min='1' max='$stock'></td>
                                    <td><input type='text' $dis class='form-control' name='barang_sn[]'></td>
                                    <td>$status</td>
                                    <td>$ket</td>
                                    <td><button class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true' onclick='deleteRow(this)'></i></button></td>
                                </tr>";
                        echo $html;
                    }else{

                    }
                } else {
                    // Jika data barang tidak ditemukan, kirimkan pesan 'Tidak ada hasil yang ditemukan'
                    echo json_encode('Tidak ada hasil yang ditemukan');
                }
            }
        }else{
            return abort(403,'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function simpanDataKeluar(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'admin'){
        $validator = Validator::make($request->all(), [
            'tanggaltranskeluar' => 'required|date',
            'slcupkeluar' => 'required|exists:up,id',
            'slculpkeluar' => 'required|exists:ulp,id',
            'barang_code.*' => 'required|exists:barang,barang_code',
            'barang_quantity.*' => 'nullable|integer|min:1',
            'barang_sn.*' => 'nullable|string|max:255',
            'status.*' => 'nullable|string|max:255',
            'keterangan.*' => 'nullable|string|max:255',
            'pemberi' => 'required|string',
            'penerima' => 'required|string',
        ], [
            'tanggaltranskeluar.required' => 'Tanggal transaksi harus diisi.',
            'tanggaltranskeluar.date' => 'Tanggal transaksi harus berupa tanggal yang valid.',
            'slcupkeluar.required' => 'Pilih UP terlebih dahulu.',
            'slcupkeluar.exists' => 'UP yang Anda pilih tidak valid.',
            'slculpkeluar.required' => 'Pilih ULP terlebih dahulu.',
            'slculpkeluar.exists' => 'ULP yang Anda pilih tidak valid.',
            'barang_code.*.required' => 'Kode barang wajib diisi.',
            'barang_code.*.exists' => 'Kode barang tidak valid.',
            'barang_quantity.*.required' => 'Quantity barang wajib diisi.',
            'barang_quantity.*.integer' => 'Quantity barang harus berupa angka.',
            'barang_quantity.*.min' => 'Quantity barang harus lebih dari atau sama dengan 1.',
            'barang_sn.*.required' => 'Serial number barang wajib diisi.',
            'barang_sn.*.max' => 'Serial number barang tidak boleh lebih dari :max karakter.'
        ]);

            $barangCodes = $request->input('barang_code');
            $barangQuantities = $request->input('barang_quantity');
            $barangSns = $request->input('barang_sn');
            

            $barangWithQuantity = false;
            foreach ($barangQuantities as $quantity) {
                if ($quantity > 0) {
                    $barangWithQuantity = true;
                    break;
                }
            }
            if (!$barangWithQuantity) {
                return redirect('/trans/keluar')->with('error', 'Transaksi Gagal: Stok Barang yang anda inputkan kosong');
            }

            $kodeTrans = Transaksi::generateTransaksi('keluar');
            try {
                // Buat transaksi baru
                $transaksi = new Transaksi;
                $transaksi->kode_trans = $kodeTrans;
                $transaksi->tanggal_trans = $request->input('tanggaltranskeluar');
                $transaksi->up_id = $request->input('slcupkeluar');
                $transaksi->ulp_id = $request->input('slculpkeluar');
                $transaksi->pemberi = $request->input('pemberi');
                $transaksi->penerima = $request->input('penerima');
                $transaksi->created_by = auth()->user()->id;
                $transaksi->created_at = now();
                $transaksi->trans_jenis = 'keluar';
                $transaksi->save();

                $transaksiId = $transaksi->id;

                $dataToStore = [];

                for ($i = 0; $i < count($barangCodes); $i++) {
                    $barang = Barang::where('barang_code', $barangCodes[$i])->first();

                    if ($barang && $barangQuantities[$i] > 0) {

                        $detail = DetailTransaksi::where('barang_id', $barang->id)
                        ->whereHas('transaksi', function ($query) {
                            $query->where('trans_jenis', 'masuk');
                        })->first();

                        $status = $detail -> status;
                        $ket = $detail-> keterangan;

                        $dataToStore[] = [
                            'trans_id' => $transaksiId,
                            'barang_id' => $barang->id,
                            'barang_quantity' => $barangQuantities[$i],
                            'barang_sn' => $barangSns[$i],
                            'status' => $status,
                            'keterangan'=> $ket
                        ];
                    }
                }
         
                DetailTransaksi::insert($dataToStore);
                
                //return redirect('/transaksi')->with('success', 'Transaksi berhasil disimpan');
                return redirect('/trans/keluar/cetak-barang-keluar/' . $transaksiId)->with('success', 'Transaksi berhasil disimpan');
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    return redirect('/transaksi')->with('error', 'Transaksi Gagal: Data sudah ada dalam database');
                } else {
                    throw $e; 
                }
            }
        }else if ($role === 'user'){
            $validator = Validator::make($request->all(), [
                'tanggaltranskeluar' => 'required|date',
                'slcupkeluar' => 'required|exists:up,id',
                'slculpkeluar' => 'required|exists:ulp,id',
                'barang_code.*' => 'required|exists:barang,barang_code',
                'barang_quantity.*' => 'nullable|integer|min:1',
                'barang_sn.*' => 'nullable|string|max:255',
                'status.*' => 'nullable|string|max:255',
                'keterangan.*' => 'nullable|string|max:255',
                'pemberi' => 'required|string',
                'penerima' => 'required|string',
            ], [
                'tanggaltranskeluar.required' => 'Tanggal transaksi harus diisi.',
                'tanggaltranskeluar.date' => 'Tanggal transaksi harus berupa tanggal yang valid.',
                'slcupkeluar.required' => 'Pilih UP terlebih dahulu.',
                'slcupkeluar.exists' => 'UP yang Anda pilih tidak valid.',
                'slculpkeluar.required' => 'Pilih ULP terlebih dahulu.',
                'slculpkeluar.exists' => 'ULP yang Anda pilih tidak valid.',
                'barang_code.*.required' => 'Kode barang wajib diisi.',
                'barang_code.*.exists' => 'Kode barang tidak valid.',
                'barang_quantity.*.required' => 'Quantity barang wajib diisi.',
                'barang_quantity.*.integer' => 'Quantity barang harus berupa angka.',
                'barang_quantity.*.min' => 'Quantity barang harus lebih dari atau sama dengan 1.',
                'barang_sn.*.required' => 'Serial number barang wajib diisi.',
                'barang_sn.*.max' => 'Serial number barang tidak boleh lebih dari :max karakter.'
            ]);
    
                $barangCodes = $request->input('barang_code');
                $barangQuantities = $request->input('barang_quantity');
                $barangSns = $request->input('barang_sn');
                
    
                $barangWithQuantity = false;
                foreach ($barangQuantities as $quantity) {
                    if ($quantity > 0) {
                        $barangWithQuantity = true;
                        break;
                    }
                }
                if (!$barangWithQuantity) {
                    return redirect('/trans/keluar')->with('error', 'Transaksi Gagal: Stok Barang yang anda inputkan kosong');
                }
    
                $kodeTrans = Transaksi::generateTransaksi('keluar');
                try {
                    // Buat transaksi baru
                    $transaksi = new Transaksi;
                    $transaksi->kode_trans = $kodeTrans;
                    $transaksi->tanggal_trans = $request->input('tanggaltranskeluar');
                    $transaksi->up_id = $request->input('slcupkeluar');
                    $transaksi->ulp_id = $request->input('slculpkeluar');
                    $transaksi->pemberi = $request->input('pemberi');
                    $transaksi->penerima = $request->input('penerima');
                    $transaksi->created_by = auth()->user()->id;
                    $transaksi->created_at = now();
                    $transaksi->trans_jenis = 'keluar';
                    $transaksi->save();
    
                    $transaksiId = $transaksi->id;
    
                    $dataToStore = [];
    
                    for ($i = 0; $i < count($barangCodes); $i++) {
                        $barang = Barang::where('barang_code', $barangCodes[$i])->first();
    
                        if ($barang && $barangQuantities[$i] > 0) {
    
                            $detail = DetailTransaksi::where('barang_id', $barang->id)
                            ->whereHas('transaksi', function ($query) {
                                $query->where('trans_jenis', 'masuk');
                            })->first();
    
                            $status = $detail -> status;
                            $ket = $detail-> keterangan;
    
                            $dataToStore[] = [
                                'trans_id' => $transaksiId,
                                'barang_id' => $barang->id,
                                'barang_quantity' => $barangQuantities[$i],
                                'barang_sn' => $barangSns[$i],
                                'status' => $status,
                                'keterangan'=> $ket
                            ];
                        }
                    }
             
                    DetailTransaksi::insert($dataToStore);
                    
                    //return redirect('/transaksi')->with('success', 'Transaksi berhasil disimpan');
                    return redirect('/trans/keluar/cetak-barang-keluar/' . $transaksiId)->with('success', 'Transaksi berhasil disimpan');
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->errorInfo[1] == 1062) {
                        return redirect('/transaksi')->with('error', 'Transaksi Gagal: Data sudah ada dalam database');
                    } else {
                        throw $e; 
                    }
                }
            }
    }
    public function barangmasuk(){
        
        $UPs = UP::all();
        $ULPs = ULP::all();
        $User = User::all();

    
        $transaksis = Transaksi::where('trans_jenis','masuk')->paginate(8);
        return view('transaksi.barangmasuk', compact('transaksis', 'UPs', 'ULPs','User'));
    }
    public function barangkeluar(){
        $UPs = UP::all();
        $ULPs = ULP::all();
        $User = User::all();

    
        $transaksis = Transaksi::where('trans_jenis','keluar')->paginate(8);
        return view('transaksi.barangkeluar', compact('transaksis', 'UPs', 'ULPs','User'));
    }
    public function cetakBarangKeluar($trans_id)
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'admin'){
            $trans = DetailTransaksi::select(
                'transaksi.created_at',
                'transaksi.pemberi',
                'transaksi.penerima',
                'barang.barang_code',
                'barang.barang_nama',
                'detail_transaksi.barang_quantity AS jumlah'
            )->join('barang', 'detail_transaksi.barang_id', '=', 'barang.id')
            ->join('transaksi', 'detail_transaksi.trans_id', '=', 'transaksi.id')
            ->where('transaksi.kode_trans', 'like', 'TK%')->where('transaksi.id', $trans_id)
            ->first();
            
            $detail = DetailTransaksi::select(
                'transaksi.created_at',
                'transaksi.pemberi',
                'transaksi.penerima',
                'barang.barang_code',
                'barang.barang_nama',
                'detail_transaksi.barang_quantity AS jumlah'
            )->join('barang', 'detail_transaksi.barang_id', '=', 'barang.id')
            ->join('transaksi', 'detail_transaksi.trans_id', '=', 'transaksi.id')
            ->where('transaksi.kode_trans', 'like', 'TK%')->where('transaksi.id', $trans_id)
            ->get();
            
            return view('transaksi.cetak-barang-keluar', compact('trans','detail'));
        }else if ($role === 'user'){
            $trans = DetailTransaksi::select(
                'transaksi.created_at',
                'transaksi.pemberi',
                'transaksi.penerima',
                'barang.barang_code',
                'barang.barang_nama',
                'detail_transaksi.barang_quantity AS jumlah'
            )->join('barang', 'detail_transaksi.barang_id', '=', 'barang.id')
            ->join('transaksi', 'detail_transaksi.trans_id', '=', 'transaksi.id')
            ->where('transaksi.kode_trans', 'like', 'TK%')->where('transaksi.id', $trans_id)
            ->first();
            
            $detail = DetailTransaksi::select(
                'transaksi.created_at',
                'transaksi.pemberi',
                'transaksi.penerima',
                'barang.barang_code',
                'barang.barang_nama',
                'detail_transaksi.barang_quantity AS jumlah'
            )->join('barang', 'detail_transaksi.barang_id', '=', 'barang.id')
            ->join('transaksi', 'detail_transaksi.trans_id', '=', 'transaksi.id')
            ->where('transaksi.kode_trans', 'like', 'TK%')->where('transaksi.id', $trans_id)
            ->get();
            
            return view('user.cetak-barang-keluar', compact('trans','detail'));
        }
    }

}