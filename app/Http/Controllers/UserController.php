<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hash;
use Validator;
use Illuminate\Support\Facades\Session;
use App\Model\Permission;
use App\Model\Roles;
use App\User;
use App\VerifyUser;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{

    
	/**
     * Where to redirect users after password is changed.
     *
     * @var string $redirectTo
     */
    
     /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        
        if(Auth::check() == false){ 
             return response('Unauthenticated.', 401);
        }

        $validator = Validator::make($request->all(), [
           'first_name' => 'required|max:50',
           'middle_name' => 'required|max:50',
           'last_name' => 'required|max:50',
           'email' => 'required|unique:users|max:50',
           'user_roles' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 401);
        }
        
        $objUser = new User;
        $objUser->name = $request->name;
        $objUser->first_name = $request->first_name;
        $objUser->middle_name = $request->midddle_name;
        $objUser->last_name = $request->last_name;
        $objUser->email = $request->email;
        $objUser->user_status = $request->status;
        $objUser->save();
        $varInsertId = $objUser->id;

        if(count($request->user_roles) > 0){
            foreach($request->user_roles AS $k=>$v){
                $exists = DB::table('role_has_permissions')
                            ->where('role_id', '=', $k)
                            ->where('user_id', '=', $varInsertId)
                            ->first();
                if (is_null($exists)) {
                    DB::table('user_has_roles')->insert(['role_id' => $k , 'user_id' => $varInsertId]);
                }
            }
        }
        return response()->json(true);
    }

    public function UserSignup(Request $request){ 
        DB::beginTransaction();
        try{ 
            // Check with existing
            //if((isset($request->email) && $request->email!='')  && (isset($request->identity) && decrypt($request->identity)  > 0)){ 
            if(isset($request->email) && $request->email!='' &&  isset($request->identity) && decrypt($request->identity) > 0){  
                
                $verifyUser = User::where('email', $request->email)->where('id', decrypt($request->identity))->where('invited', 1)->first();

                if(isset($verifyUser)){
                    $id = $verifyUser->id;
                    $validator = Validator::make($request->all(), [
                       'first_name' => 'required|max:50',
                       'middle_name' => 'required|max:50',
                       'last_name' => 'required|max:50',
                       'email' => "required|email|unique:users,email,".$verifyUser->id,
                       'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                    ]); 

                    if ($validator->fails()) { 
                        return response()->json(['errors'=>$validator->errors()], 401);
                    }

                User::where('id', $id)->update(array('name'=>$request->first_name, 'first_name' => $request->first_name, 'middle_name' => $request->middle_name, 'last_name' => $request->last_name, 'password'=>  Hash::make($request->password), 'invited'=> 2));
                    
                    $varToken = $verifyUser->remember_token;

                    $verifyUser = VerifyUser::create([
                        'user_id' => $id,
                        'token' => $varToken
                    ]);
                    
                    $user = array('name'=>$request->name, 'email'=>$request->email, 'token' => $varToken);
                   
                    Mail::to($request->email)->send(new VerifyMail($user));
                }
                else{

                    $validator = Validator::make($request->all(), [
                       'first_name' => 'required|max:50',
                       'middle_name' => 'required|max:50',
                       'last_name' => 'required|max:50',
                       'email' => 'required|unique:users|max:50',
                       'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                    ]);    

                    if ($validator->fails()) { 
                        return response()->json(['errors'=>$validator->errors()], 401);
                    }

                    $objUser = new User;
                    $objUser->name = $request->name;
                    $objUser->first_name = $request->first_name;
                    $objUser->middle_name = $request->middle_name;
                    $objUser->last_name = $request->last_name;
                    $objUser->email = $request->email;
                    $objUser->password = Hash::make($request->password);
                    $objUser->user_status = $request->user_status;
                    $objUser->save();
                    
                    $varInsertId = $objUser->id;
                    $varToken = str_random(40) . time();

                    $verifyUser = VerifyUser::create([
                        'user_id' => $varInsertId,
                        'token' => $varToken
                    ]);

                    $user = array('name'=>$request->name, 'email'=>$request->email, 'token' => $varToken);
                   
                    Mail::to($request->email)->send(new VerifyMail($user));
                }
            }
            else{ 
                $validator = Validator::make($request->all(), [
                   'first_name' => 'required|max:50',
                   'middle_name' => 'required|max:50',
                   'last_name' => 'required|max:50',
                   'email' => 'required|unique:users|max:50',
                   'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                ]);   

                $varInvitied = User::where('email', $request->email)->where('verified', 0)->value('invited');

                if($varInvitied == 1){
                    $varErrMsg = ['Account' => array('Veryfication issue. Please verify your account by following the service email link.')];
                    return response()->json(['errors'=>$varErrMsg], 401);
                }
                else{
                    if ($validator->fails()) {
                        return response()->json(['errors'=>$validator->errors()], 401);
                    }
                }

                $objUser = new User;
                $objUser->name = $request->name;
                $objUser->first_name = $request->first_name;
                $objUser->middle_name = $request->middle_name;
                $objUser->last_name = $request->last_name;
                $objUser->email = $request->email;
                $objUser->password = Hash::make($request->password);
                $objUser->user_status = $request->user_status;
                $objUser->save();

                $varInsertId = $objUser->id;
                $varToken = str_random(40) . time();

                $verifyUser = VerifyUser::create([
                    'user_id' => $varInsertId,
                    'token' => $varToken
                ]);
                $user = array('name'=>$request->name, 'email'=>$request->email, 'token' => $varToken);
               
                Mail::to($request->email)->send(new VerifyMail($user));
            }

            DB::commit();
            return response()->json(true);

        }catch(\Exception $e) { 
            DB::rollBack();
            $varErrMsg = ['Invalid' => array('Invalid data.')];
            return response()->json(['errors'=>$varErrMsg], 404);
            //return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    public function verifyUser($token){
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->user_status = 'active';
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
 
        return redirect('/login')->with('status', $status);
    }
    

    
        /* Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ShowRegisterForm(Request $request){
        if($request->get('uid')){ 
            $verifyUser = User::where('remember_token', $request->get('uid'))->first();
            if(isset($verifyUser)){
                if($verifyUser->invited == 0 || $verifyUser->invited == 2){
                    return view('auth.register')->with('warning', "Your email account '".$verifyUser->email."' is already registered.")->with('success','')->with('email','')->with('defineid','');
                }
                else if($verifyUser->invited == 1){
                    return view('auth.register')->with('warning', "")->with('success',"Please complete your signup process with contact email: ")->with('email',$verifyUser->email)->with('defineid', encrypt($verifyUser->id));
                }
             }
            else{ 
                return view('auth.register')->with('warning', "Sorry unable to find your identity.")->with('success','')->with('email','')->with('defineid','');
            }
        }
        
       return view('auth.register')->with('warning', '')->with('success','')->with('email','')->with('defineid','');
        
    }



}
