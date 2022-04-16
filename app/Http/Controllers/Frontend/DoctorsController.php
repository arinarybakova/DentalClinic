<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DoctorsController extends Controller {
    public function index()
    {
        $users = User::select(DB::raw('*, concat(firstname, " ", lastname) as name'))
            ->where('usertype', config('app.usertype_dentist'))
            ->orderBy('name')
            ->get();

        return $users;
    }
}