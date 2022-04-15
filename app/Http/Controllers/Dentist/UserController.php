<?php

namespace App\Http\Controllers\Dentist;

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

    public function patients()
    {
        return view("dentist.patients");
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }
}
