<?php

namespace App\Http\Controllers\Dentist;

use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //    $procedures = Procedure::all();
        //    return response()->json($procedures);
        return view("dentist.procedures");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function procedures(Request $request)
    {
        if ($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            if ($request->get('filter') !== null) {
                $procedures = Procedure::where('title', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('details', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orderBy('title');
            } else {
                $procedures = Procedure::orderBy('title');
            }
            $pagination = $procedures->paginate($limit)->toArray();
            $procedures = $pagination['data'];
            $total_pages = $pagination['to'];
            $total = $pagination['total'];
        } else {
            $procedures = [];
            $total = 0;
        }
        return ['procedures' => $procedures, 'total' => $total];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Procedure $procedure)
    {
        return response()->json($procedure);
    }
}
