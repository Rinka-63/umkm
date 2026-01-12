<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
Use App\Models\Barang;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

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

        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

    View::composer('dashboard.*', function ($view) {

        $notif_list = Barang::where('stok', '<=', 10)
                            ->orderBy('stok', 'asc')
                            ->get();

        $notif_count = $notif_list->count();

        $view->with([
            'notif_list'  => $notif_list,
            'notif_count' => $notif_count
        ]);
    });

        Paginator::useBootstrapFive();
    }
}
