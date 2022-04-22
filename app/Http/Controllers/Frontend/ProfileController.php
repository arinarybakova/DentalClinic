<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller {
    public function index()
    {
        return view('user.profile');
               
    }

    public function profile(Request $request)
    {
     
        /* Current Login User Details */
        $user = Auth::user();
        var_dump($user);
      
        /* Current Login User ID */
        $userID = Auth::user()->id; 
        var_dump($userID);
          
        /* Current Login User Name */
        $userName = Auth::user()->firstname; 
        var_dump($userName);
          
        /* Current Login User Email */
        $userEmail = Auth::user()->email; 
        var_dump($userEmail);
        /*$id = Auth::user()->id;
        $barcode = request('barcode');
        $users = DB::table('users')
        ->where('id', $id)
        ->select('id', 'firstname', 'lastname', 'email', 'phone', 'password')
        ->get();
        return response()->json($getuser); */
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