<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function schedule()
    {
        return view('admin.schedule');
    }
}
