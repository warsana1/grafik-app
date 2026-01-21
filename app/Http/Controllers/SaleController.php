<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data untuk Tabel CRUD
        $sales = Sale::orderBy('transaction_date', 'desc')->get();

        // 2. Olah data untuk Grafik (Total Penjualan per Tanggal)
        $chartData = Sale::selectRaw('transaction_date, SUM(amount) as total')
            ->groupBy('transaction_date')
            ->orderBy('transaction_date')
            ->get();

        // Pisahkan label (tanggal) dan data (total)
        $labels = $chartData->pluck('transaction_date');
        $data = $chartData->pluck('total');

        return view('sales.index', compact('sales', 'labels', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
        ]);

        Sale::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Sale::find($id)->delete();
        return redirect()->back()->with('success', 'Data dihapus!');
    }
    // ... method index, store, destroy yang sudah ada ...

    // Menampilkan halaman form edit
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.edit', compact('sale'));
    }

    // Memproses update data ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
        ]);

        $sale = Sale::findOrFail($id);
        
        // Update data
        $sale->update([
            'product_name' => $request->product_name,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date
        ]);

        // Redirect kembali ke halaman utama (dashboard)
        return redirect()->route('sales.index')->with('success', 'Data berhasil diupdate!');
    }
}
    