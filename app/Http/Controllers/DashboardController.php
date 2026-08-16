<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\MenuMakanan;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Filter tanggal yang digunakan seluruh dashboard.
     * @param mixed $query
     * @param string $column
     * @return mixed
     */
    private function filterTanggal($query, $column = 'created_at')
    {
        $filter = request('filter', 'today');
        switch ($filter) {
            case 'week':
                return $query->whereBetween($column, [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
            case 'month':
                return $query->whereBetween($column, [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
            case 'year':
                return $query->whereBetween($column, [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ]);
            case 'all':
                return $query;
            default:
                return $query->whereDate($column, Carbon::today());
        }
    }

    public function index()
    {
        $totalOrderMinum   = $this->getTotalOrderMinum();
        $labaKotor         = $this->getLabaKotor();
        $labaBersih        = $labaKotor * 0.8;
        $produkPalingLaris = $this->getProdukPalingLaris();
        $grafikPenjualan   = $this->getGrafikPenjualan();
        $stokMenipis       = $this->getStokMenipis();
        $stokHabis         = $this->getStokHabis();
        $kehadiranHariIni  = $this->getKehadiranHariIni();
        $totalTransaksi    = $this->getTotalTransaksi();
        $labaBersih = $this->getLabaBersih($labaKotor);

        $filterLabel = [
            'today' => 'Hari Ini',
            'week'  => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year'  => 'Tahun Ini',
            'all'   => 'Semua Data'
        ][request('filter', 'today')];

        return view('dashboard.index', compact(
            'totalOrderMinum',
            'labaKotor',
            'labaBersih',
            'produkPalingLaris',
            'grafikPenjualan',
            'stokMenipis',
            'stokHabis',
            'kehadiranHariIni',
            'totalTransaksi',
            'filterLabel'
        ));
    }

    private function getTotalOrderMinum()
{
    $query = DetailTransaksi::query()
        ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
        ->join('menu_makanan', 'detail_transaksi.menu_id', '=', 'menu_makanan.menu_id')
        ->where(function ($q) {
            $q->where('menu_makanan.kategori', 'like', '%minum%')
              ->orWhere('menu_makanan.kategori', 'like', '%minuman%');
        });
    return $this->filterTanggal($query, 'transaksi.created_at')
        ->sum('detail_transaksi.qty');
}

private function getLabaKotor()
{
    $totalPenjualan = $this->filterTanggal(
        Transaksi::query()
    )->sum('total_harga');
    $queryHpp = DB::table('detail_transaksi')
        ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
        ->join('menu_makanan', 'detail_transaksi.menu_id', '=', 'menu_makanan.menu_id');
    $totalHpp = $this->filterTanggal(
        $queryHpp,
        'transaksi.created_at'
    )
    ->selectRaw('SUM(detail_transaksi.qty * menu_makanan.hpp) as total_hpp')
    ->value('total_hpp');

    return ($totalPenjualan ?? 0) - ($totalHpp ?? 0);
}

private function getLabaBersih($labaKotor)
{
    return $labaKotor * 0.8;
}

private function getTotalTransaksi()
{
    return $this->filterTanggal(
        Transaksi::query()
    )->count();
}

private function getProdukPalingLaris()
{
    $query = DB::table('detail_transaksi')
        ->join( 'transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id' )
        ->join( 'menu_makanan', 'detail_transaksi.menu_id', '=', 'menu_makanan.menu_id' );

    $query = $this->filterTanggal( $query, 'transaksi.created_at' );

    return $query
        ->select( 'menu_makanan.menu_id', 'menu_makanan.nama_makanan', 'menu_makanan.kategori', 'menu_makanan.harga',
            DB::raw('SUM(detail_transaksi.qty) as total_terjual'),
            DB::raw('SUM(detail_transaksi.subtotal) as total_omzet')
        )
        ->groupBy(
            'menu_makanan.menu_id',
            'menu_makanan.nama_makanan',
            'menu_makanan.kategori',
            'menu_makanan.harga'
        )
        ->orderByDesc('total_terjual')
        ->limit(3)
        ->get();
}

private function getGrafikPenjualan()
{
    $filter = request('filter', 'today');
    $labels = [];
    $data = [];
    switch ($filter) {
        /*
        ======================
        HARI INI
        ======================
        */

    case 'today':
        for ($jam = 0; $jam < 24; $jam++) {

            $labels[] = sprintf('%02d:00', $jam);

            $data[] = Transaksi::whereDate('created_at', Carbon::today())
                ->whereRaw('HOUR(created_at) = ?', [$jam])
                ->sum('total_harga');
        }
        break;

        /*
        ======================
        MINGGU
        ======================
        */

        case 'week':
            $awal = Carbon::now()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $tanggal = $awal->copy()->addDays($i);
                $labels[] = $tanggal->translatedFormat('D');
                $data[] = Transaksi::whereDate(
                        'created_at',
                        $tanggal
                    )
                    ->sum('total_harga');
            }
            break;
        /*
        ======================
        BULAN
        ======================
        */

        case 'month':
            $jumlahHari = Carbon::now()->daysInMonth;
            for ($i = 1; $i <= $jumlahHari; $i++) {
                $tanggal = Carbon::create(
                    now()->year,
                    now()->month,
                    $i
                );
                $labels[] = $i;
                $data[] = Transaksi::whereDate(
                        'created_at',
                        $tanggal
                    )
                    ->sum('total_harga');
            }
            break;

        /*
        ======================
        TAHUN
        ======================
        */

        case 'year':
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $labels[] = Carbon::create()
                    ->month($bulan)
                    ->translatedFormat('M');
                $data[] = Transaksi::whereYear(
                        'created_at',
                        now()->year
                    )
                    ->whereMonth(
                        'created_at',
                        $bulan
                    )
                    ->sum('total_harga');
            }
            break;

        /*
        ======================
        SEMUA
        ======================
        */

        case 'all':
            for ($i = 11; $i >= 0; $i--) {
                $bulan = Carbon::now()->copy()->subMonths($i);
                $labels[] = $bulan->translatedFormat('M Y');
                $data[] = Transaksi::whereYear(
                        'created_at',
                        $bulan->year
                    )
                    ->whereMonth(
                        'created_at',
                        $bulan->month
                    )
                    ->sum('total_harga');
            }
            break;
    }
    return [
        'labels' => $labels,
        'data'   => $data
    ];
}

private function getStokMenipis()
{
    return Inventory::where('stock', '<', 5)
        ->where('stock', '>', 0)
        ->orderBy('stock')
        ->get();
}

private function getStokHabis()
{
    return Inventory::where('stock', 0)
        ->orderBy('nama_bahan')
        ->get();
}

private function getKehadiranHariIni()
{
    return $this->filterTanggal(
        Kehadiran::with('karyawan'),
        'tanggal'
    )
    ->orderBy('tanggal', 'desc')
    ->get();
}

}