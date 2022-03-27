<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function doctors()
    {
        return view("admin.doctors");
    }

    public function patients()
    {
        return view("admin.patients");
    }

    public function users(Request $request)
    {
        if ($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            $users = User::select(DB::raw('*, concat(firstname, " ", lastname) as name'));
            if($request->get('usertype') !== null) {
                $users->where('usertype', $request->get('usertype'));
            }
            if ($request->get('filter') !== null) {
                $users->where(DB::raw('concat(firstname, " ", lastname)'), 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('email', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orderBy('name');
            } else {
                $users->orderBy('name');
            }
            $pagination = $users->paginate($limit)->toArray();
            $users = $pagination['data'];
            $total = $pagination['total'];
        } else {
            $users = [];
            $total = 0;
        }
        return ['users' => $users, 'total' => $total];
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
        try {
            $user = User::find($id);
            $user->fill($request->post())->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false,
                'user' => []
            ]);
        }
        return response()->json([
            'success'   => true,
            'user' => $user
        ]);
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
