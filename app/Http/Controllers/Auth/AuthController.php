<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Hash;
  
class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.register');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            switch(Auth::user()->usertype) {
                case config('app.usertype_admin'):
                    redirect()->intended('admin')
                        ->withSuccess('You have Successfully loggedin');
                 case config('app.usertype_dentist'):
                    redirect()->intended('dentist')
                        ->withSuccess('You have Successfully loggedin');
                default:
                redirect()->intended(RouteServiceProvider::HOME)
                        ->withSuccess('You have Successfully loggedin');
            }
        }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'firstname' => 'required|max:255',
            'lastname'  => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
           
        $data = $request->all();
        if($this->create($data)) {
            return redirect(route('login'))->withSuccess('Great! You have Successfully loggedin');
        } else {
            return redirect(route('register'))->withSuccess('Error. User was not created.');
        }
         
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'firstname' => $data['name'],
        'lastname'  => $data['lastname'],
        'email'     => $data['email'],
        'phone'     => $data['phone'],
        'usertype'  => config('app.usertype_patient'),
        'password'  => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return redirect(route('index'));
    }
}