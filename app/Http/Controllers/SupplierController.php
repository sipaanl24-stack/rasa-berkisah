<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as RequestModel;
use App\Models\Inventory;
use Carbon\Carbon;

class SupplierController extends Controller
{
public function index(Request $request)
{
    $filter = $request->filter;

    $query = RequestModel::select('kode_request')
        ->groupBy('kode_request')
        ->orderByDesc(\DB::raw('MAX(created_at)'));

    if ($filter == 'today') {
        $query->whereDate('created_at', Carbon::today());
    }

    if ($filter == 'week') {
        $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    if ($filter == 'month') {
        $query->whereMonth('created_at', Carbon::now()->month)
              ->whereYear('created_at', Carbon::now()->year);
    }

    if ($filter == 'year') {
        $query->whereYear('created_at', Carbon::now()->year);
    }

    $kodeRequest = $query->paginate(5)->withQueryString();

    $kodeList = $kodeRequest->pluck('kode_request');

    $data = RequestModel::whereIn('kode_request', $kodeList)
        ->orderByDesc('created_at')
        ->get()
        ->groupBy('kode_request');

    $notif = RequestModel::where('status', 'pending')
        ->distinct('kode_request')
        ->count('kode_request');

    $kategori = Inventory::select('kategori')
        ->distinct()
        ->orderBy('kategori')
        ->pluck('kategori');

    return view('supplier.index', compact(
        'data',
        'notif',
        'kategori',
        'kodeRequest',
        'filter'
    ));
}

    public function updateStatus(Request $request, $id)
    {
        $first = RequestModel::findOrFail($id);

        RequestModel::where('kode_request', $first->kode_request)
            ->update([
                'status' => $request->status,
                'keterangan_penolakan' => $request->keterangan_penolakan
            ]);

        return redirect()->back()
            ->with('success', 'Status berhasil diupdate');
    }
}