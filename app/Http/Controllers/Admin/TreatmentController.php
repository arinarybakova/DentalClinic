<?php

namespace App\Http\Controllers\Admin;

use App\Models\Treatment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreatmentController extends Controller
{
    public function treatments(Request $request)
    {
        $totalPrice = 0;

        if ($request->get('page') !== null && $request->get('patient')) {
            $limit = $request->get('limit') ?? 10;
            $treatments = Treatment::select(
                'treatments.*',
                'treatment_stage_status.status',
                'procedures.title',
                'procedures.price',
            )
                ->join('treatment_stage_status', 'treatment_stage_status.id', 'treatments.fk_status')
                ->join('procedures', 'procedures.id', 'treatments.fk_procedure')
                ->where('treatments.fk_patient', '=', $request->get('patient'));

            if ($request->get('filter') !== null) {
                $treatments->where('title', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('price', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('status', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%');
            }
            $totalPrice = DB::table(DB::raw("({$treatments->toSql()}) as sub"))
                ->select(DB::raw(DB::raw('SUM(case when fk_status != ' . config('app.canceled_status_id') . ' then price else 0 end) as totalPrice')))
                ->mergeBindings($treatments->getQuery())->first();
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
            'totalPrice' => is_int($totalPrice) ? $totalPrice : $totalPrice->totalPrice,
            'isDentist' => $this->isDentist(),
        ];
    }
    public function store(Request $request)
    {
        $requiredKeys = ['fk_patient', 'fk_procedure', 'fk_status', 'new', 'status'];
        try {
            foreach ($request->post() as $treatmentData) {
                if (count(array_diff_key(array_keys($treatmentData), $requiredKeys)) === 0) {
                    Treatment::create($treatmentData);
                }
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false
            ]);
        }
        return response()->json([
            'success'   => true
        ]);
    }
    public function approve(int $id)
    {
        try {
            $treatment = Treatment::find($id);
            $treatment->fk_status = config('app.approved_status_id');
            $treatment->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false,
                'treatment' => []
            ]);
        }
        return response()->json([
            'success'   => true,
            'treatment' => $treatment
        ]);
    }
    public function cancel($id)
    {
        try {
            $treatment = Treatment::find($id);
            $treatment->fk_status = config('app.canceled_status_id');
            $treatment->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false,
                'treatment' => []
            ]);
        }
        return response()->json([
            'success'   => true,
            'treatment' => $treatment
        ]);
    }
}
