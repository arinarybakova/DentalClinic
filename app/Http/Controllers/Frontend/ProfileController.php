<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    public function profile(Request $request)
    {
        $user = Auth::user()->toArray();

        $keep = [
            'id',
            'firstname',
            'lastname',
            'email',
            'phone',
        ];
        foreach (array_keys($user) as $key) {
            if (!in_array($key, $keep)) {
                unset($user[$key]);
            }
        }

        return $user;
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
