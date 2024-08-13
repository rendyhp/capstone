<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\View\View;

class DetailTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $barangs = Barang::all();
        $transaksis = Transaksi::all();
        $detailtransaksis = DetailTransaksi::with('transaksi')->paginate(5);
        return view('detailtransaksi', compact('barangs', 'transaksis','detailtransaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('detail_transaksi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $Detail = new DetailTransaksi;
            $Detail -> id = $request->input('id');
            $Detail -> trans_id = $request->input('transid');
            $Detail -> barang_id = $request->input('barangid');
            $Detail -> barang_quantity = $request->input('barangqtt');
            $Detail -> barang_sn = $request->input('barangsn');

            $Detail ->save();
        
            return redirect('/detailtransaksi')->with('success','Data berhasil ditambahkan');
            } catch (\Illuminate\Database\QueryException $e) {
                // Check for unique constraint violation
                if ($e->errorInfo[1] == 1452) {
                    echo '<script>alert("Detail Transaksi Gagal.");</script>';
                    return redirect('detailtransaksi')->with('error','Detail Transaksi Gagal Ditambahkan');
                } else {
                    throw $e; // Rethrow the exception if it's not due to unique constraint
                }
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailTransaksi $detailtransaksi)
    {
        $Detail = DetailTransaksi::findOrFail($detailtransaksi->id);
        return view('detailtransaksi', compact('Detail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
            $Detail = Transaksi::findOrFail($request->input('id'));
            $Detail -> trans_id = $request->input('transid');
            $Detail -> barang_id = $request->input('barangid');
            $Detail -> barang_quantity = $request->input('barangqtt');
            $Detail -> barang_sn = $request->input('barangsn');

            $Detail ->save();
        
            return redirect('/detailtransaksi')->with('success','Data berhasil ditambahkan');
            } catch (\Illuminate\Database\QueryException $e) {
                // Check for unique constraint violation
                if ($e->errorInfo[1] == 1452) {
                    echo '<script>alert("Detail Transaksi Gagal.");</script>';
                    return redirect('detailtransaksi')->with('error','Detail Transaksi Gagal Ditambahkan');
                } else {
                    throw $e; // Rethrow the exception if it's not due to unique constraint
                }
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailTransaksi $detail_transaksi)
    {
        DetailTransaksi::destroy($detail_transaksi->id);
        return redirect('/detailtransaksi')->with('success','Data berhasil dihapus');
    }
}