<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;
use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class TreatmentController extends Controller
{
    public function index()
    {
        return view('user.treatments');
    }

    public function treatments(Request $request)
    {
        $totalPrice = 0;

        if ($request->get('page') !== null && Auth::hasUser()) {
            $limit = $request->get('limit') ?? 10;
            $treatments = Treatment::select(
                'treatments.*',
                'treatment_stage_status.status',
                'procedures.title',
                'procedures.price'
            )
                ->join('treatment_stage_status', 'treatment_stage_status.id', 'treatments.fk_status')
                ->join('procedures', 'procedures.id', 'treatments.fk_procedure')
                ->where('fk_patient', '=', Auth::user()->id);


            if ($request->get('filter') !== null) {
                $treatments->where(function ($query) use ($request) {
                    return $query
                        ->where('title', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                        ->orWhere('price', 'LIKE',  '%' . $this->escape_like($request->get('filter')) .  '%')
                        ->orWhere('status', 'LIKE',  '%' . $this->escape_like($request->get('filter')) .  '%');
                });
            }

            $totalPrice = DB::table(DB::raw("({$treatments->toSql()}) as sub"))
                ->select(DB::raw(DB::raw('SUM(case when fk_status != ' . config('app.canceled_status_id') . ' then price else 0 end) as totalPrice')))
                ->mergeBindings($treatments->getQuery())->first();

            /** sort start */
            $columns = [
                'id',
                'title',
                'price',
                'status',
            ];
            if ($request->get('sortBy') !== null && in_array($request->get('sortBy'), $columns)) {
                $desc = $request->get('sortDesc') == 'true' ? 'DESC' : 'ASC';
                $treatments->orderBy($request->get('sortBy'), $desc);
            } else {
                $treatments->orderBy('status');
            }
            /** sort end */

            $pagination = $treatments->paginate($limit)->toArray();
            $treatments = $pagination['data'];
            $total = $pagination['total'];
        } else {
            $treatments = [];
            $total = 0;
        }
        return [
            'treatments' => $treatments,
            'total' => $total,
            'totalPrice' => $totalPrice->totalPrice,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        return response()->json($treatment);
    }
}
