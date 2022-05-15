<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

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
            $users = User::select(DB::raw('users.*, concat(users.firstname, " ", users.lastname) as name'));
            if($this->isDentist()) {
                $users->join('appointments', 'appointments.fk_patient', 'users.id')
                    ->where('appointments.fk_dentist', '=', Auth::user()->id);
            }
            if($request->get('usertype') !== null) {
                $users->where('usertype', $request->get('usertype'));
            }
            if ($request->get('filter') !== null) {
                $users->where(function($q) use ($request) {
                    $q->where(DB::raw('concat(firstname, " ", lastname)'), 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                        ->orWhere('email', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%');
                });
            }
            $users->distinct()->orderBy('name');
            $pagination = $users->paginate($limit)->toArray();
            $users = $pagination['data'];
            $total = $pagination['total'];
        } else {
            $users = [];
            $total = 0;
        }
        return [
            'users' => $users, 
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
            $data = [
               'usertype'   => config('app.usertype_dentist'),
               'password'   => md5(rand())
            ];
            $user = User::create(array_merge($request->post(), $data));

            $callback = function($user, $token){
                $user->sendPasswordCreateNotification($token);
            };
            $status = $this->broker()->sendResetLink(
                $request->only('email'),
                $callback
            );

            if($status !== Password::RESET_LINK_SENT) {
                return response()->json([
                    'success'   => false,
                    'status' => $status,
                    'user' => []
                ]);
            }
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

    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
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
    public function destroy(int $id)
    {
        $user = User::find($id);
        if($user !== null) {
            $user->delete();
            return response()->json([
                'success'   => true
            ]);
        } else {
            return response()->json([
                'success'   => false
            ]);
        }
    }

    public function treatment(int $id, Request $request)
    {
            $user = User::find($id);
            $treatments = Treatment::select(
                'treatments.*', 'treatment_stage_status.status', 'procedures.title', 'procedures.price')
            
            ->join('treatment_stage_status', 'treatment_stage_status.id', 'treatments.fk_status')
            ->join('procedures', 'procedures.id', 'treatments.fk_procedure')
            ->where('fk_patient', '=', Treatment::user()->id);
            

            if ($request->get('filter') !== null) {
                $treatments->where('title', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('price', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('status', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orderBy('status');
            } else {
                $treatments->orderBy('id');
            }
        return ['treatments' => $treatments];
    }
}
