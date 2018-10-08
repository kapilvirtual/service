<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hash;
use Validator;
use Illuminate\Support\Facades\Session;
use App\Model\Permission;

class PermissionController extends Controller
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
    protected $redirectTo = '/admin/permission';

    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */  
	public function index(){

        if(Auth::check() == false){ 
            return redirect('admin/login');
        }

		$permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
	}

     /* update a existing created resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePermission(Request $request){
        if(Auth::check() == false){ 
             return response('Unauthenticated.', 401);
        }

        try{
            $validator = Validator::make($request->all(), [
               'name' => 'required|unique:permission,name,'.decrypt($request->updateID).'|max:50',
               'permission_access' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()], 401);
            }

            $varPermission =  implode(',',$request->permission_access);

            Permission::where('id', decrypt($request->updateID))->update(['name'=>$request->name, 'permission_access'=>$varPermission]);
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
     * return the response result for permissions array
     * Handle authenticate and get response
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getPermissions(Request $request){

        $varSearchPermission = $request->get('term');
        $permissions = Permission::orderBy('name', 'ASC');
       
        if (!empty($varSearchPermission)) {
            $permissions->where('name', 'LIKE', '%'.$varSearchPermission.'%');
        }

        $list = $permissions;

        $list = $list->get()->pluck('name', 'id');
        return response()->json($list);
    }

    /**
     * return the response result listing from database for permissions
     * Handle authenticate and get response
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function permissionList(Request $request){
        
        if(Auth::check() == false){ 
            return response('Unauthenticated.', 401);
        }

        $varSearchPermission = $request->get('search')['value'];
        $data = array();
        $permissions = Permission::orderBy('created_at', 'DESC');

        $permissions->get();
        $record_total = $permissions->count();

        if (!empty($varSearchPermission)) {
            $permissions->where('name', 'LIKE', '%'.$varSearchPermission.'%');
        }
       
        // Here are required to define searching condition
        $recordsFiltered = $permissions->count();

        $list = $permissions->skip($start = $request->get('start'))->take($request->get('length'));

        $list = $list->get();
        
        if($list->count()){
            foreach($list AS $permission) {
                $id =  encrypt($permission->id);
                $name = $permission->name;
                $guard_name = $permission->guard_name;
                $access ='';
                $checked = '';
                $arrAccess = array('add','edit', 'view', 'delete');
                $arrPermissionAccess = explode(',',$permission->permission_access);
                foreach($arrAccess as $v){
                    if (in_array( $v, $arrPermissionAccess))
                        $checked = 'checked';
                    else
                       $checked = '';

                    $access .="<label><input class='form-check-input check' type='checkbox' name='per_".$v."' ".$checked." disabled >".ucfirst($v)."</label>&nbsp;";
                }
                
                $action = '<input class="btn btn-xs btn-info per-edit" type="button" data-val="'.$id.'"  value="Edit"> &nbsp;<input class="btn btn-xs btn-danger pre-delete" type="button" data-val="'.$id.'" value="Delete">';

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
                $todo = Permission::findOrFail($id);
               // $arrAccess = explode(',', $todo->permission_access);
                //$todo["access"] =  $arrAccess;
                return response()->json($todo);
            }
        }
        catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
     }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {   
        $e = '';
        $arrRequestID =  $request->id;

        try {
            if(count($arrRequestID) > 0){    
               foreach($arrRequestID as $id){
                    $id = decrypt($id);
                    $todo = Permission::findOrFail($id);
                    $todo->delete(); //DELETE OCCURS HERE AFTER RECORD FOUND                
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
