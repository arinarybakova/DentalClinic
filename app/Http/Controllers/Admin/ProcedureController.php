<?php

namespace App\Http\Controllers\Admin;

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
    return view("admin.procedure");
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

    public function procedures(Request $request) {
        if($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            if($request->get('filter') !== null) {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $procedure = Procedure::create($request->post());
        return response()->json([
            'procedure'=>$procedure
        ]);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Procedure $procedure)
    {
        $procedure->fill($request->post())->save();
        return response()->json([
            'procedure'=>$procedure
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Procedure $procedure)
    {
        $procedure->delete();
        return response()->json([
            'message' => 'Procedure removed'
        ]);
    }
}
