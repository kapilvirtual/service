<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hash;
use Validator;
use Illuminate\Support\Facades\Session;
use App\Model\Permission;
use App\Model\Roles;
use App\User;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    { 
		$this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);
        });
    }
	
	/**
     * Where to redirect users after password is changed.
     *
     * @var string $redirectTo
     */
    protected $redirectTo = '/admin/roles';

    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */  
	public function index(){
        if(Auth::check() == false){ 
            return redirect('admin/login');
        }

        /*$roles = User::where('id','>','0')
                    ->with('userroles')
                    ->orderBy('created_at', 'DESC')->get();
                    foreach($roles as $user){
                        print_r($user->userroles);die;
                    }*/

        return view('admin.users.index');
	}


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




     /* update a existing created resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        if(Auth::check() == false){ 
             return response('Unauthenticated.', 401);
        }

        try{

            $validator = Validator::make($request->all(), [
               'name' => 'required|unique:roles,name,'.decrypt($request->updateID).'|max:50',
               'permission_access' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()], 401);
            }

            
            roles::where('id', decrypt($request->updateID))->update(['name'=>$request->name]);

            if(count($request->permission_access) > 0){
                DB::table('role_has_permissions')->where('role_id', '=', decrypt($request->updateID))->delete();                
                foreach($request->permission_access AS $k=>$v){
                    $exists = DB::table('role_has_permissions')
                                ->where('permission_id', '=', $k)
                                ->where('role_id', '=', decrypt($request->updateID))
                                ->first();
                    if (is_null($exists)) {
                        DB::table('role_has_permissions')->insert(['permission_id' => $k , 'role_id' => decrypt($request->updateID)]);
                    }
                }
            }


            return response()->json(true);
        }
        catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

    }




    /* Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addPermission(Request $request){
      
        if(Auth::check() == false){ 
             return response('Unauthenticated.', 401);
        }

        $validator = Validator::make($request->all(), [
           'name' => 'required|unique:permission|max:50',
           'permission_access' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 401);
        }

        $varPermission =  implode(',',$request->permission_access);

        $objPermission = new Permission;
        $objPermission->name = $request->name;
        $objPermission->guard_name = $request->name;
        $objPermission->permission_access = $varPermission;
        $objPermission->save();
        return response()->json(true);
    }

    /**
     * return the response result listing from database for permissions
     * Handle authenticate and get response
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request){
        
        if(Auth::check() == false){ 
             return response('Unauthenticated.', 401);
        }
        
        $varSearchUser = $request->get('search')['value'];
        $data = array();
        
        $users = User::where('id','>','0')
                    ->with('userroles')
                    ->orderBy('created_at', 'DESC');

        $users->get();
        $record_total = $users->count();

        if (!empty($varSearchUser)) {
            $users->where('first_name', 'LIKE', '%'.$varSearchUser.'%');
            $users->orWhere('middle_name', 'LIKE', '%'.$varSearchUser.'%');
            $users->orWhere('last_name', 'LIKE', '%'.$varSearchUser.'%');
            $users->orWhere('email', 'LIKE', '%'.$varSearchUser.'%');
        }

        // Here are required to define searching condition
        $recordsFiltered = $users->count();

        $list = $users->skip($start = $request->get('start'))->take($request->get('length'));

        $list = $list->get();
       
        if($list->count()){
            foreach($list AS $user) {
                $varId =  encrypt($user->id);
                $varName = $user->name;
                $varFirstName = $user->first_name;
                $varMiddleName = $user->middle_name;
                $varLastName = $user->last_name;
                $varEmail = $user->email;
                $varStatus = ucfirst($user->user_status);
                $varGuardName = $user->guard_name;
                $access ='';
                $checked = '';
                
                if(count($user->userroles)) {
                    foreach($user->userroles as $val){
                        $access .='<span class="label label-info label-many">'.$val->name.'</span>';
                    }
                }

                $action = '<input class="btn btn-xs btn-info per-edit" type="button" data-val="'. $varId.'"  value="Edit"> &nbsp;<input class="btn btn-xs btn-danger user-delete" type="button" data-val="'. $varId.'" value="Delete">';

                $data[] = array( $varId, $varFirstName, $varMiddleName, $varLastName, $varEmail,  $access, $varStatus , $action);
            }
        }

        return response()->json(['draw'=>$request->get('draw'), 'recordsTotal'=>$record_total, 'recordsFiltered'=>$recordsFiltered, 'data'=>$data]);
    }



}
