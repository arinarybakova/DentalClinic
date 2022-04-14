<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AdminViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Using Closure based composers...
        View::composer('admin.sidebar', function ($view) {
            $links = [];

            $links[] = (object)[
                'href'      => route('admin'),
                'icon'      => 'fas fa-home',
                'name'      => 'Pagrindinis',
                'route'     => 'admin'
            ];
            $links[] = (object)[
                'href'      => route('admin.patients'),
                'icon'      => 'fas fa-users',
                'name'      => 'Pacientai',
                'route'     => 'admin/patients'
            ];
            $links[] = (object)[
                'href'      => route('admin.doctors'),
                'icon'      => 'fas fa-user-md',
                'name'      => 'Gyd. odontologai',
                'route'     => 'admin/doctors'
            ];
            $links[] = (object)[
                'href'      => route('admin.appointment'),
                'icon'      => 'fas fa-calendar-check',
                'name'      => 'Vizitai',
                'route'     => 'admin/appointment'
            ];
            $links[] = (object)[
                'href'      => route('admin.schedule'),
                'icon'      => 'fas fa-calendar-alt',
                'name'      => 'Tvarkaraštis',
                'route'     => 'admin/schedule'
            ];
            $links[] = (object)[
                'href'      => route('admin.procedure'),
                'icon'      => 'fas fa-hand-holding-medical',
                'name'      => 'Procedūros',
                'route'     => 'admin/procedure'
            ];
            $links[] = (object)[
                'href'      => route('admin.profile'),
                'icon'      => 'fas fa-user-cog',
                'name'      => 'Paskyra',
                'route'     => 'admin/profile'
            ];

            $view->with('links', $links);
        });
    }
}
