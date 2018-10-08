<?php 
namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller {
   
    public function index(){
       if(Auth::check()){
            return view('admin.home');
       }

       return view('admin.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function postLogin(Request $request)
    { 
        //if ($this->auth->attempt($credentials, $request->has('remember')))
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials))
        {  
            return redirect()->intended('/admin/home');
        }

        return redirect()->back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }


    /**
     * Handle an authentication logout attempt.
     *
     * @return Response
     */
    public function logout(Request $request){
        // $varAllSession = $request->session();
        // echo "<pre>";print_r($varAllSession);die;
        Session::flush();

        return redirect('/admin');
    }


}