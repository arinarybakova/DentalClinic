<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProcedureController extends Controller {
    public function index()
    {
        return view('user.procedures');
    }

    public function procedures(Request $request)
    {
        $procedures = Procedure::orderBy('title')->get();
        return $procedures->toArray();
    }
}