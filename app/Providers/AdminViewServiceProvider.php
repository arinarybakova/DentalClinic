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
                'href'      => 'admin/html/patients.html',
                'icon'      => 'fas fa-users',
                'name'      => 'Pacientai',
                'route'     => false
            ];
            $links[] = (object)[
                'href'      => 'admin/html/doctors.html',
                'icon'      => 'fas fa-user-md',
                'name'      => 'Daktarai',
                'route'     => false
            ];
            $links[] = (object)[
                'href'      => 'admin/html/appointments.html',
                'icon'      => 'fas fa-calendar-check',
                'name'      => 'Vizitai',
                'route'     => false
            ];
            $links[] = (object)[
                'href'      => 'admin/html/htmlschedule.html',
                'icon'      => 'fas fa-calendar-alt',
                'name'      => 'Tvarkaraštis',
                'route'     => false
            ];
            $links[] = (object)[
                'href'      => route('admin.procedure'),
                'icon'      => 'fas fa-hand-holding-medical',
                'name'      => 'Procedūros',
                'route'     => 'admin/procedure'
            ];
            $links[] = (object)[
                'href'      => 'admin/html/currentuser.html',
                'icon'      => 'fas fa-user-cog',
                'name'      => 'Paskyra',
                'route'     => false
            ];

            $view->with('links', $links);
        });
    }
}
