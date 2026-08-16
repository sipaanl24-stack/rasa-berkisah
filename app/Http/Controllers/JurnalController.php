<?php

namespace App\Http\Controllers;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Carbon\Carbon;


class JurnalController extends Controller
{
public function index(Request $request)
{
    $query = Jurnal::query();

    $filter = $request->filter ?? 'all';

    switch ($filter) {

        case 'today':
            $query->whereDate('tanggal', Carbon::today());
            break;

        case 'week':
            $query->whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
            break;

        case 'month':
            $query->whereMonth('tanggal', Carbon::now()->month)
                  ->whereYear('tanggal', Carbon::now()->year);
            break;

        case 'year':
            $query->whereYear('tanggal', Carbon::now()->year);
            break;
    }

    if ($request->filled('date_range')) {

    preg_match_all('/\d{4}-\d{2}-\d{2}/', $request->date_range, $matches);
    if(count($matches[0]) == 2){
        $query->whereBetween('tanggal', [
            $matches[0][0],
            $matches[0][1]
        ]);
    }
    }

    $jurnal = $query
        ->orderByDesc('tanggal')
        ->get();

    return view('jurnal.index',[
        'jurnal'=>$jurnal,
        'filter'=>$filter,
        'totalDebit'=>$jurnal->sum('debit'),
        'totalKredit'=>$jurnal->sum('kredit'),
    ]);
}

}