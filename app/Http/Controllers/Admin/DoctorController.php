<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.doctors");
    }

    public function doctors(Request $request)
    {
        if ($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            if ($request->get('filter') !== null) {
                $doctors = User::where('name', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('email', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orderBy('name');
            } else {
                $doctors = User::orderBy('name');
            }
            $pagination = $doctors->paginate($limit)->toArray();
            $doctors = $pagination['data'];
            $total_pages = $pagination['to'];
            $total = $pagination['total'];
        } else {
            $doctors = [];
            $total = 0;
        }
        return ['doctors' => $doctors, 'total' => $total];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try {
        //     $procedure = Procedure::create($request->post());
        // } catch (\Illuminate\Database\QueryException $exception) {
        //     return response()->json([
        //         'success'   => false,
        //         'procedure' => []
        //     ]);
        // }
        // return response()->json([
        //     'success'   => true,
        //     'procedure' => $procedure
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
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
        // try {
        //     $procedure = Procedure::find($id);
        //     $procedure->fill($request->post())->save();
        // } catch (\Illuminate\Database\QueryException $exception) {
        //     return response()->json([
        //         'success'   => false,
        //         'procedure' => []
        //     ]);
        // }
        // return response()->json([
        //     'success'   => true,
        //     'procedure' => $procedure
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'User removed'
        ]);
    }
}
