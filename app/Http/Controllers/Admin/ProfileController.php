<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller {
    public function index()
    {
        return view('admin.profile');
    }

    public function profile(Request $request)
    {
        
        //return ['user' => $user, 'total' => $total];
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

}