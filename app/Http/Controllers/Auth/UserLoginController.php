<?php 
namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserLoginController extends Controller {
   
  
    public function index(){
       //if(Auth::check()){
        //    return view('user.home');
      // }

       //return view('admin.login');
    }

    public function ShowLoginForm(){
         return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function doLogin(Request $request)
    {   
        $auth = false;
        $validator = Validator::make($request->all(), [
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->only('email'));
        }

        
        $userdata = array(
            'email'     => $request->email,
            'password'  => $request->password,
            'user_status' => 'active'
        );

        $remember = $request->has('remember') ? true : false; 

        if (Auth::attempt($userdata,  $remember)) {
            return redirect()->intended('/home');
        }
        else{
            $varUserId = User::where('email', $request->email)->value('user_status');
            if($varUserId == 'inactive'){
                return Redirect::back()->with('flash_notice', 'your account has been suspended.')->withInput();
            }

            return Redirect::back()->with('flash_notice', 'Username/password combination was incorrect.')->withInput();
        }


        
        //if ($this->auth->attempt($credentials, $request->has('remember')))
        

        //return redirect()->back()->withErrors([
        //    'email' => 'These credentials do not match our records.',
        //]);
    }


    /**
     * Handle an authentication logout attempt.
     *
     * @return Response
     */
    public function logout(Request $request){
      
        Session::flush();

        return redirect('/admin');
    }


}