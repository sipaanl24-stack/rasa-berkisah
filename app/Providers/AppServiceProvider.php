<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Request as RequestModel;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Paginator::useBootstrapFive();
         View::composer('*', function ($view) {

        $notif = RequestModel::where('status', 'pending')->count();

        $notifikasi = RequestModel::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $view->with([
            'notif' => $notif,
            'notifikasi' => $notifikasi
        ]);

    });
    }}
