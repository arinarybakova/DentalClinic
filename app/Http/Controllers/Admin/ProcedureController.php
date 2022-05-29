<?php

namespace App\Http\Controllers\Admin;

use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Support\Facades\Schema;


class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.procedures");
    }

    public function procedures(Request $request)
    {
        if ($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            if ($request->get('filter') !== null) {
                $procedures = Procedure::where('title', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('details', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%');
            } else {
                $procedures = Procedure::where('id', '>', 0);
            }
            if ($request->get('sortBy') !== null && Schema::hasColumn('procedures', $request->get('sortBy'))) {
                $desc = $request->get('sortDesc') == 'true' ? 'DESC' : 'ASC';
                $procedures->orderBy($request->get('sortBy'), $desc);
            } else {
                $procedures->orderBy('title');
            }
            $pagination = $procedures->paginate($limit)->toArray();
            $procedures = $pagination['data'];
            $total = $pagination['total'];
        } else {
            $procedures = [];
            $total = 0;
        }
        return [
            'procedures' => $procedures,
            'total' => $total,
            'isDentist' => $this->isDentist(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $procedure = Procedure::create($request->post());
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false,
                'procedure' => []
            ]);
        }
        return response()->json([
            'success'   => true,
            'procedure' => $procedure
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
    public function update(int $id, Request $request)
    {
        try {
            $procedure = Procedure::find($id);
            $procedure->fill($request->post())->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false,
                'procedure' => []
            ]);
        }
        return response()->json([
            'success'   => true,
            'procedure' => $procedure
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $procedure = Procedure::find($id);
        if ($procedure !== null) {
            if($this->validateDestroy($id)) {
                $procedure->delete();
                return response()->json([
                    'success'   => true
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'errorMsg'  => 'Nepavyko ištrinti procedūros. Procedūra yra įtraukta į bent vieną paciento gydymo plano etapą'
                ]);
            }
        } else {
            return response()->json([
                'success'   => false
            ]);
        }
    }

    private function validateDestroy(int $id): bool 
    {
        $treatmentStagesCount = Treatment::where('fk_procedure', '=', $id)
            ->count();

        return $treatmentStagesCount === 0;
    }
}
