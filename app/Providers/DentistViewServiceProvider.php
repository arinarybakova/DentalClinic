<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class DentistViewServiceProvider extends ServiceProvider
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
        View::composer('dentist.sidebar', function ($view) {
            $links = [];

            $links[] = (object)[
                'href'      => route('dentist.patients'),
                'icon'      => 'fas fa-users',
                'name'      => 'Pacientai',
                'route'     => 'dentist/patients'
            ];
            $links[] = (object)[
                'href'      => route('dentist.appointment'),
                'icon'      => 'fas fa-calendar-check',
                'name'      => 'Vizitai',
                'route'     => 'dentist/appointment'
            ];
            $links[] = (object)[
                'href'      => route('dentist.schedule'),
                'icon'      => 'fas fa-calendar-alt',
                'name'      => 'Tvarkaraštis',
                'route'     => 'dentist/schedule'
            ];
            $links[] = (object)[
                'href'      => route('dentist.procedure'),
                'icon'      => 'fas fa-hand-holding-medical',
                'name'      => 'Procedūros',
                'route'     => 'dentist/procedure'
            ];
            $links[] = (object)[
                'href'      => route('dentist.profile'),
                'icon'      => 'fas fa-user-cog',
                'name'      => 'Paskyra',
                'route'     => 'dentist/profile'
            ];

            $view->with('links', $links);
        });
    }
}
