<?php
namespace App\Http\Controllers;
use App\Models\Sale;

class ChartController extends Controller {
    public function index() {
        $data = Sale::all();
        return view('grafik', compact('data'));
    }
}
