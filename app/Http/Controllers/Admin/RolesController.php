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
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
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
        
        //$permissions = Permission::get()->pluck('name', 'name');
        //$roles = Roles::with('permissions')->get()->toArray();->whereNull('deleted_at')
        return view('admin.roles.index', compact('permissions'));
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
           'name' => 'required|unique:permission|max:50',
           'permission_access' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 401);
        }

        $objRoles = new Roles;
        $objRoles->name = $request->name;
        $objRoles->guard_name = $request->name;
        $objRoles->save();
        $varInsertId = $objRoles->id;

        if(count($request->permission_access) > 0){
            foreach($request->permission_access AS $k=>$v){
                $exists = DB::table('role_has_permissions')
                            ->where('permission_id', '=', $k)
                            ->where('role_id', '=', $varInsertId)
                            ->first();
                if (is_null($exists)) {
                    DB::table('role_has_permissions')->insert(['permission_id' => $k , 'role_id' => $varInsertId]);
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




   

    /**
     * return the response result listing from database for permissions
     * Handle authenticate and get response
     *
     * @return \Illuminate\Http\Response
     */
    public function roleList(Request $request){
        
        if(Auth::check() == false){ 
             return response('Unauthenticated.', 401);
        }
        
        $varSearchPermission = $request->get('search')['value'];
        $data = array();
        
        $roles = Roles::whereNull('deleted_at')
                    ->with('permissions')
                    ->orderBy('created_at', 'DESC');

        $roles->get();
        $record_total = $roles->count();

        if (!empty($varSearchPermission)) {
            $roles->where('name', 'LIKE', '%'.$varSearchPermission.'%');
        }

        // Here are required to define searching condition
        $recordsFiltered = $roles->count();

        $list = $roles->skip($start = $request->get('start'))->take($request->get('length'));

        $list = $list->get();
        
        if($list->count()){
            foreach($list AS $role) {
                $id =  encrypt($role->id);
                $name = $role->name;
                $guard_name = $role->guard_name;
                $access ='';
                $checked = '';
                
                if(count($role->permissions)) {
                    foreach($role->permissions as $val){
                        $access .='<span class="label label-info label-many">'.$val->name.'</span>';
                    }
                }

                $action = '<input class="btn btn-xs btn-info per-edit" type="button" data-val="'.$id.'"  value="Edit"> &nbsp;<input class="btn btn-xs btn-danger role-delete" type="button" data-val="'.$id.'" value="Delete">';

                $data[] = array($id, $name, $access, $action);
            }
        }

        return response()->json(['draw'=>$request->get('draw'), 'recordsTotal'=>$record_total, 'recordsFiltered'=>$recordsFiltered, 'data'=>$data]);
    }

    



     /**
     * Get the result for database on the basis of id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function getRecord($id){
        $e = '';

        try {
            $id = decrypt($id);
            if($id > 0){ 
                $roles = Roles::where('id', $id)
                    ->with(array('permissions'=>function($query){
                        $query->select('id','name');
                    }))->first();
                return response()->json($roles);
            }
        }
        catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
     }



     /**
     * return the response result for permissions array
     * Handle authenticate and get response
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getRoles(Request $request){

        $varSearchRoles = $request->get('term');
        $roles = Roles::orderBy('name', 'ASC');
       
        if (!empty($varSearchRoles)) {
            $roles->where('name', 'LIKE', '%'.$varSearchRoles.'%');
        }

        $list = $roles;

        $list = $list->get()->pluck('name', 'id');
        return response()->json($list);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destory(Request $request)
    {   
        $e = '';
        $arrRequestID =  $request->id;
        try {
            if(count($arrRequestID) > 0){
               foreach($arrRequestID as $id){
                    $id = decrypt($id);
                    $objRole = Roles::findOrFail($id);
                    $objRole->delete(); //DELETE OCCURS HERE AFTER RECORD FOUND                
                }
                return response()->json(true);
            }
        }
        catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    /**
     * Get a validator for an incoming change password request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|unique:permission|max:50',
            'permission_access' => 'required',
        ]);
    }

}
