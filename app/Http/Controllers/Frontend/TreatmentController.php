<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TreatmentController extends Controller {
    public function index()
    {
        return view('user.treatments');
    }

    public function treatments(Request $request)
    {
        if ($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            
            $treatments = Treatment::orderBy('date');
            $pagination = $treatments->paginate($limit)->toArray();
            $treatments = $pagination['data'];
            $total_pages = $pagination['to'];
            $total = $pagination['total'];
        
        } else {
            $treatments = [];
            $total = 0;
        }
        return ['treatments' => $treatments, 'total' => $total];
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