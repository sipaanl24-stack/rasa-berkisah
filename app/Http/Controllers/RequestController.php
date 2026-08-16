<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as RequestModel;
use App\Models\Inventory;

class RequestController extends Controller
{
public function index()
{
    $requestPending = RequestModel::select('kode_request')
        ->where('status', 'pending')
        ->groupBy('kode_request')
        ->orderByRaw('MAX(created_at) DESC')
        ->paginate(5, ['*'], 'pending_page');

    $dataPending = $requestPending->through(function ($request) {
        return RequestModel::where('kode_request', $request->kode_request)->get();
    });

    $requestHistory = RequestModel::select('kode_request')
        ->whereIn('status', ['diterima', 'ditolak'])
        ->groupBy('kode_request')
        ->orderByRaw('MAX(created_at) DESC')
        ->paginate(5, ['*'], 'history_page');

    $dataHistory = $requestHistory->through(function ($request) {
        return RequestModel::where('kode_request', $request->kode_request)->get();
    });

    $kategori = Inventory::select('kategori')
        ->distinct()
        ->orderBy('kategori')
        ->pluck('kategori');

    return view('request.index', compact(
        'dataPending',
        'requestPending',
        'dataHistory',
        'requestHistory',
        'kategori'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|array',
            'nama_bahan.*' => 'required',

            'kategori' => 'required|array',
            'kategori.*' => 'required',

            'sisa_stock' => 'required|array',
            'sisa_stock.*' => 'required|integer',

            'satuan' => 'required|array',
            'satuan.*' => 'required',

            'keterangan' => 'nullable'
        ]);

        $kode = 'REQ-' . date('Ymd') . rand(100, 999);

        foreach ($request->nama_bahan as $i => $nama) {

            RequestModel::create([
                'kode_request'  => $kode,
                'nama_bahan'    => $nama,
                'kategori'      => $request->kategori[$i],
                'sisa_stock'    => $request->sisa_stock[$i],
                'satuan'        => $request->satuan[$i],
                'keterangan'    => $request->keterangan,
                'tanggal_kirim' => now()->format('Y-m-d'),
                'status'        => 'pending'
            ]);

        }
        return redirect()
            ->back()
            ->with('success', 'Request berhasil dikirim');
    }
}