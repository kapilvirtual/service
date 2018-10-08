<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\ServiceDocument;
use App\Model\InvitedUsers;
use Validator;
use Auth;
use App\User;
use App\Model\Service;
use App\Model\CompanyInfo;
use App\Model\CompanyContactInfo;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\ServiceExistingMail;
use App\Mail\ServiceMail;
use Illuminate\Support\Facades\Mail;

class ServiceController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    	if(Auth::guest())
	   		return view('admin.login');
    }


    /**
     * Store a newly uploaded document in storage.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function documentStore(Request $request)
    {
    	$file = $request->file('file');
        //$filename = $file->getClientOriginalName();die;

        //echo "<pre>";print_r($file);die;

        $filename = $file->getClientOriginalName();
        $extension  = $file->getClientOriginalExtension();

       // $filename = time().'_'.date('Ymd').'_'.$imageName.'.'.$extension;
        $file->move(public_path('servicedocument'), $filename);
        
        $imageUpload = new ServiceDocument();
        $imageUpload->service_id = '0';
        $imageUpload->filename = $filename;
        $imageUpload->save();
        return response()->json(['success'=>$filename]);
    }

    /**
     * Store a newly uploaded company logo in storage.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function logoStore(Request $request){ 

       // $this->validate($request, [
         //   'ajax_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //]);
    	
        try{

	        $file = $request->file('ajax_file');

	        $filename = $file->getClientOriginalName();
	        
	        $extension  = $file->getClientOriginalExtension();

	        $filename = time().'_'.date('Ymd').'_thumbnail_'.$filename;
	        
	        $varFilenameOrg = time().'_'.date('Ymd').'_org_'.$filename;

	        $destinationPath = public_path('companylogo');
	     
	   
	        $img = Image::make($file->getRealPath());
	        $img->resize(250, 150, function ($constraint) {
	            $constraint->aspectRatio();
	        })->save($destinationPath.'/'.$filename);

	        $file->move($destinationPath, $varFilenameOrg);
	        return response()->json(['success'=> $filename]);  
	    }
	    catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

       /* $file = $request->file('ajax_file');

        $filename = $file->getClientOriginalName();
        
        $extension  = $file->getClientOriginalExtension();

        $filename = time().'_'.date('Ymd').'_'.$filename.'.'.$extension;

        $image_resize = Image::make($file->getRealPath());              
        $image_resize->resize(320, 240);
        $file->move(public_path('companylogo'), $filename);*/

            
    }

    /**
     * Delete stored file from the source
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return filename
     */
    public function fileDestroy(Request $request)
    {
    	try{
	        $filename = $request->get('filename');
	        ServiceDocument::where('filename',$filename)->delete();
	        $path=public_path().'/servicedocument/'.$filename;
	        if (file_exists($path)) {
	            unlink($path);
	        }
	        return $filename;  
    	}
    	catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    
	/**
     * Store a newly CRETED service record information.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
    */

    public function storeServiceInfo(Request $request)
    {  
    	
 		DB::beginTransaction();
        try{

        	$validator = Validator::make($request->all(), [
                'service_title' => 'required|max:100',
                'validation_date' => 'required|date|date_format:Y-m-d',
                'service_description' => 'required',
                'regulations_standard' => 'required',
                'data_classification' => 'required',
                'business_controls' => 'required',
                'security_controls' => 'required',
            ]);

            if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()], 401);
            }
			$objServiceInfo = array();
		
            $objService = new Service;
            $objService->user_id =  Auth::id();
	        $objService->service_title = $request->service_title;
	        $objService->validation_date = $request->validation_date;
	        $objService->service_description = $request->service_description;
	        $objService->regulations_standard = $request->regulations_standard;
	        $objService->data_classification = $request->data_classification;
	        $objService->business_controls = $request->business_controls;
	        $objService->security_controls = $request->security_controls;
	        $objService->service_status = 'solidgreen';
	        $objService->route_id = rand(pow(10, 9-1), pow(10, 9)-1);
	        $objService->check_status = '1';
	       
	        $objService->save();
	        $varServiceId = $objService->id;
	             
	        if(isset($request->docs) && count($request->docs) > 0){ 
	        	foreach($request->docs as $k=>$v){
				 $arrDocs = ServiceDocument::where('filename', $v)->update(['service_id'=>$varServiceId, 'upload_status'=>'1']);
	        	}
	        }
	        
	       /* if(isset($request->userdetails) && count($request->userdetails) > 0){ 
            	foreach($request->userdetails as $key=>$val){
            		$useremail = $val['useremails'];
            		$saveAccess = ($val['useraccess']=='read')?'readonly':'both';
					$useraccess = ($val['useraccess']=='read')?'Read Only':'Read/Write';

					if (User::where('email', '=', $useremail)->count() > 0) {
						
						$varUserId = User::where('email', $useremail)->value('id');

						$info =  array('title' => $request->service_title, 'company' => $request->company_name, 'description' => $request->service_description, 'accesstype' =>$useraccess);
						Mail::to($useremail)->send(new ServiceExistingMail($info));												
					}
					else{

						$varToken = Str::random(60);

						$objUser = new User;
				        $objUser->email = $useremail;
				        $objUser->name = '';
				        $objUser->first_name = '';
				        $objUser->middle_name = '';
				        $objUser->last_name = '';
				        $objUser->password = '';
				        $objUser->remember_token = $varToken;
				        $objUser->verified = '0';
				        $objUser->invited = '1';
				        $objUser->user_status = 'active';
				        $objUser->save();
				        $varUserId = $objUser->id;

						$info =  array('title' => $request->service_title, 'company' => $request->company_name, 'description' => $request->service_description,'emailaddress' => $useremail,'accesstype' =>$useraccess, 'token' =>$varToken);

						Mail::to($useremail)->send(new ServiceMail($info));	
					}

					$objUserInvited = new InvitedUsers;
					$objUserInvited->service_id = $varServiceId;
					$objUserInvited->user_id = $varUserId;
					$objUserInvited->access_type = $saveAccess;
					$objUserInvited->save();
            	}
            }*/

            //$objServiceInfo['id'] = encrypt($objService->id);
            //$objServiceInfo['user_id'] = encrypt($objService->user_id);
           // $objServiceInfo['service_title'] = $objService->service_title;
           // $objServiceInfo['data_classification'] = $objService->data_classification;
            //$objServiceInfo['service_status'] = $objService->service_status;
            //$objServiceInfo['check_status'] = $objService->check_status;
  			DB::commit();
            return response()->json(['data' => $objService], 200);
        }
        catch(\Exception $e) {
        	DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }


    }    

    /**
     * Store a newly CRETED service record information.
     *
     * @return \Illuminate\Http\Response
    */
    public function getUserCompanyProfile(){
    	try{
        	$objReturn = array();
        	$arrServices = array();
        	$arrGetUSerServices = array();
        	$objReturn['shared_services'] = array();
        	$objReturn['shared_services_forme'] = array();
        	if (CompanyInfo::where('user_id', '=', Auth::id())->count() > 0) {

        		$objCompanyInfo = CompanyInfo::where('user_id', '=', Auth::id())->first();
 
        		if($objCompanyInfo->id > 0){ 
        			$objCCInfo = CompanyContactInfo::where('company_id', '=', $objCompanyInfo->id)->first();
        			$objCompanyInfo = $objCompanyInfo->toArray();
					$objCompanyContactInfo = $objCCInfo->toArray();
					$objReturn = array_merge($objCompanyInfo, $objCompanyContactInfo);
					$objReturn['return_status'] = true;
					unset($objReturn['id']);
					unset($objReturn['user_id']);
					unset($objReturn['company_id']);
					unset($objReturn['updated_at']);
					unset($objReturn['created_at']);


					// Get user services shared by me
					
					$objGetUserServices = Service::where('user_id',Auth::id())->orderBy('created_at', 'DESC')->get()->toArray();
					foreach($objGetUserServices as $key=>$val){
						$varCountUsers = DB::table('service_invited_user')->where('service_id', $val['id'])->count();
						$arrGetUSerServices[$key]['id'] = encrypt($val['id']);
						$arrGetUSerServices[$key]['user_id'] = encrypt($val['user_id']);
						$arrGetUSerServices[$key]['total_users'] = $varCountUsers;
						$arrGetUSerServices[$key]['service_title'] = $val['service_title'];
						$arrGetUSerServices[$key]['service_description'] = $val['service_description'];
						$arrGetUSerServices[$key]['data_classification'] = $val['data_classification'];
						$arrGetUSerServices[$key]['service_status'] = $val['service_status'];
						$arrGetUSerServices[$key]['check_status'] = $val['check_status'];
					}
					
					$objReturn['shared_services'] = $arrGetUSerServices;


					$objServices = DB::table('service_invited_user')->where('user_id', '=',  Auth::id())->get();

					foreach ($objServices as $key => $value) {
	                	$objGetUserServices = Service::where('id', $value->service_id)->orderBy('created_at', 'DESC')->get();
						foreach($objGetUserServices as $key=>$val){
							$arr = $this->getUsercompanyInfo($val->user_id);
							$arrGetUSerServices[$key]['poc'] = $arr['poc'];
							$arrGetUSerServices[$key]['poc_email'] = $arr['poc_email'];
							$arrGetUSerServices[$key]['service_provider'] = $arr['service_provider'];
							$arrGetUSerServices[$key]['service_id'] = encrypt($val->id);
							$arrGetUSerServices[$key]['service_access'] = $value->access_type;
							$arrGetUSerServices[$key]['subscriber_id'] = encrypt($val->user_id);
							$arrGetUSerServices[$key]['service_title'] = $val->service_title;
							$arrGetUSerServices[$key]['service_description'] = $val->service_description;
							$arrGetUSerServices[$key]['data_classification'] = $val->data_classification;
							$arrGetUSerServices[$key]['service_status'] = $val->service_status;
							$arrGetUSerServices[$key]['check_status'] = $val->check_status;
						}
                	}

                	 $objReturn['shared_services_forme'] = $arrGetUSerServices;



					return response()->json(['data' => $objReturn], 200);
         		}
        	}

        	$objReturn['return_status'] = false;

        	// Get services is shared for myself by subscriber
			$objServices = DB::table('service_invited_user')->where('user_id', '=',  Auth::id())->get();
                foreach ($objServices as $key => $value) {
                	
                	$objGetUserServices = Service::where('id', $value->service_id)->orderBy('created_at', 'DESC')->get();
					foreach($objGetUserServices as $key=>$val){
						$arr = $this->getUserCompanyInfo($val->user_id);
					
						$arrGetUSerServices[$key]['poc'] = $arr['poc'];
						$arrGetUSerServices[$key]['poc_email'] = $arr['poc_email'];
						$arrGetUSerServices[$key]['service_provider'] = $arr['service_provider'];
						$arrGetUSerServices[$key]['service_id'] = encrypt($val->id);
						$arrGetUSerServices[$key]['service_access'] = $value->access_type;
						$arrGetUSerServices[$key]['subscriber_id'] = encrypt($val->user_id);
						$arrGetUSerServices[$key]['service_title'] = $val->service_title;
						$arrGetUSerServices[$key]['service_description'] = $val->service_description;
						$arrGetUSerServices[$key]['data_classification'] = $val->data_classification;
						$arrGetUSerServices[$key]['service_status'] = $val->service_status;
						$arrGetUSerServices[$key]['check_status'] = $val->check_status;
					}
                }


                //print_r($arrGetUSerServices);die;
               // $objReturn['shared_services_forme'] = $arrGetUSerServices;

        	//return response()->json(['data' => $objReturn], 200);
        	
        }
        catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public  function getUserCompanyInfo($userid){
    	$arr = array();
    	if($userid > 0){
    		$varServiceProvider = User::where('id', $userid)->value('name');

    		$varCompInfoID = CompanyInfo::where('user_id', '=', $userid)->value('id');
    		$objCCInfo = CompanyContactInfo::where('company_id', '=', $varCompInfoID)->first();
    		if(isset($objCCInfo)){
    			$arr = array('poc'=>$objCCInfo->contact_name, 'poc_email'=>$objCCInfo->contact_email, 'service_provider' =>$varServiceProvider);	
    		}
    	}
    	return $arr;
    }
	/**
     * Store a newly Store company inforamtion for user
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
    */
    public function storeCompanyinfo(Request $request){
    	
    	DB::beginTransaction();
    	$objReturn  = array();
    	try{
    		
    		$validator = Validator::make($request->all(), [
                'company_website' => 'required|max:50',
                'company_name' => 'required|max:30',
                'company_address' => 'required|max:100',
                'company_city' => 'required|max:30',
                'company_state' => 'required|max:30',
                'company_zip' => 'required|max:10',
                'contact_name' => 'required|max:60',
                'contact_phone_number' => 'max:20',
                'contact_phone_ext' => 'max:10',
                'contact_email' => 'required|max:40',
                'contact_alt' => 'max:80'
            ]);


            if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()], 422);
            }
            
            $varLogo = ($request->company_logo)? $request->company_logo: '';
            $objCompanyInfo = CompanyInfo::create([
     			'user_id' => Auth::id(),
        		'company_name' => $request->company_name,
        		'company_website' => $request->company_website,
        		'company_address' => $request->company_address,
        		'company_city' => $request->company_city,
        		'company_state' => $request->company_state,
        		'company_zip' => $request->company_zip,
        		'company_logo' => $varLogo,
        		'company_status' => '1'
    		]);
           
            $objCompanyContactInfo = CompanyContactInfo::create([
     			'company_id' => $objCompanyInfo->id,
        		'contact_name' => $request->contact_name,
        		'contact_phone_number' => $request->contact_phone_number,
        		'contact_phone_ext' => $request->contact_phone_ext,
        		'contact_email' => $request->contact_email,
        		'contact_alt' => $request->contact_alt
    		]);
            
            if($objCompanyContactInfo->id > 0){
            	$objCompanyInfo = $objCompanyInfo->toArray();
				$objCompanyContactInfo = $objCompanyContactInfo->toArray();
				$objReturn = array_merge($objCompanyInfo, $objCompanyContactInfo);
            	DB::commit();
				
				return response()->json(['data' => $objReturn], 200);
			}
			return response()->json(['errors' => 'Something went wrong please try again.'], 422);
    	}
        catch(\Exception $e) {
        	DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

	/**
     * Get those services are shared by others subscriber for user
     *
     * @return \Illuminate\Http\Response
    */
    public function getForUserSharedService(){
    	//if(Auth::check() == false){ 
    	//	return response()->json(['error' => 'Unauthenticated'], 401);
        //}
        try{
			$objReturn  = array();
			$arrGetServices = array();
			// Get services is shared for myself by subscriber
				$objServices = DB::table('service_invited_user')->where('user_id', '=',  Auth::id())->get();
				
				foreach ($objServices as $key => $value) {
                	
                	$objGetUserServices = Service::where('id', $value->service_id)->orderBy('created_at', 'DESC')->get();
					foreach($objGetUserServices as $k=>$val){
						$arr = $this->getUsercompanyInfo($val->user_id);
					
						$arrGetServices[$key]['poc'] = $arr['poc'];
						$arrGetServices[$key]['poc_email'] = $arr['poc_email'];
						$arrGetServices[$key]['service_provider'] = $arr['service_provider'];
						$arrGetServices[$key]['service_id'] = encrypt($val->id);
						$arrGetServices[$key]['service_access'] = $value->access_type;
						$arrGetServices[$key]['route'] = $value->route_id;
						$arrGetServices[$key]['subscriber_id'] = encrypt($val->user_id);
						$arrGetServices[$key]['service_title'] = $val->service_title;
						$arrGetServices[$key]['service_description'] = $val->service_description;
						$arrGetServices[$key]['data_classification'] = $val->data_classification;
						$arrGetServices[$key]['service_status'] = $val->service_status;
						$arrGetServices[$key]['check_status'] = $val->check_status;
					}
                }

                $objReturn['shared_services_forme'] = $arrGetServices;

        	return response()->json(['data' => $objReturn], 200);
        }
        catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Get those services are shared by subscriber
     *
     * @return \Illuminate\Http\Response
    */

    public function getServicesFromOtherUser(){
    	try{
			$objReturn  = array();
			$arrGetUserServices = array();

			$objGetUserServices = Service::where('user_id',Auth::id())->orderBy('created_at', 'DESC')->get()->toArray();
				foreach($objGetUserServices as $key=>$val){
					$varCountUsers = DB::table('service_invited_user')->where('service_id', $val['id'])->count();
					$arrGetUserServices[$key]['id'] = encrypt($val['id']);
					$arrGetUserServices[$key]['user_id'] = encrypt($val['user_id']);
					$arrGetUserServices[$key]['route'] = $val['route_id'];
					$arrGetUserServices[$key]['total_users'] = ($varCountUsers>0)?$varCountUsers:'&nbsp;&nbsp;';
					$arrGetUserServices[$key]['service_title'] = $val['service_title'];
					$arrGetUserServices[$key]['service_description'] = $val['service_description'];
					$arrGetUserServices[$key]['data_classification'] = $val['data_classification'];
					$arrGetUserServices[$key]['service_status'] = $val['service_status'];
					$arrGetUserServices[$key]['check_status'] = $val['check_status'];
				}

			$objReturn['shared_services'] = $arrGetUserServices;
			return response()->json(['data' => $objReturn], 200);
		}
		catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

    }

    /**
     * Update the service request is shared by other users to leave it
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     *
     * @return \Illuminate\Http\Response
    */
    public function leaveService(Request $request){
        try{
        	$validator = Validator::make($request->all(), [
            	'service_request' => 'required',
        	]);

        	if ($validator->fails()) { 
            	return response()->json(['errors'=>$validator->errors()], 422);
        	}

        	$varServiceRequest = decrypt($request->service_request);
        	if($varServiceRequest > 0){
        		if (InvitedUsers::where('service_id', '=', $varServiceRequest)->where('user_id', Auth::id())->count() > 0) {
        			InvitedUsers::where('service_id', $varServiceRequest)->where('user_id', Auth::id())->delete();

        			$objReturn  = array();
					$arrGetServices = array();
					// Get services is shared for myself by subscriber
						$objServices = DB::table('service_invited_user')->where('user_id', '=',  Auth::id())->get();
						foreach ($objServices as $key => $value) {
		                	
		                	$objGetUserServices = Service::where('id', $value->service_id)->orderBy('created_at', 'DESC')->get();
							foreach($objGetUserServices as $k=>$val){
								$arrCompany = $this->getUsercompanyInfo($val->user_id);
							
								$arrGetServices[$key]['poc'] = $arrCompany['poc'];
								$arrGetServices[$key]['poc_email'] = $arrCompany['poc_email'];
								$arrGetServices[$key]['service_provider'] = $arrCompany['service_provider'];
								$arrGetServices[$key]['service_id'] = encrypt($val->id);
								$arrGetServices[$key]['route'] = $value->route_id;
								$arrGetServices[$key]['service_access'] = $value->access_type;
								$arrGetServices[$key]['subscriber_id'] = encrypt($val->user_id);
								$arrGetServices[$key]['service_title'] = $val->service_title;
								$arrGetServices[$key]['service_description'] = $val->service_description;
								$arrGetServices[$key]['data_classification'] = $val->data_classification;
								$arrGetServices[$key]['service_status'] = $val->service_status;
								$arrGetServices[$key]['check_status'] = $val->check_status;
							}
		                }

		                $objReturn['shared_services_forme'] = $arrGetServices;

		        	return response()->json(['data' => $objReturn], 200);
				}
				else{
					$varErrMsg = ['Invalid' => array('Record already deleted. Invalid Access.')];
                    return response()->json(['errors'=>$varErrMsg], 404);
				}
        	}
        	else{
        		return response()->json(['errors' => ['Invalid' => array('Something went wrong.')]], 404);	
        	}
        }
        catch(\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the service request is shared by other users to leave it
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     *
     * @return \Illuminate\Http\Response
    */
    public function deleteService(Request $request){
    	
        try{
        	$validator = Validator::make($request->all(), [
            	'service_request' => 'required',
        	]);

        	if ($validator->fails()) { 
            	return response()->json(['errors'=>$validator->errors()], 422);
        	}

        	$varServiceRequest = decrypt($request->service_request);
        	if($varServiceRequest > 0){
        		$objService = Service::where('id', '=', $varServiceRequest)->where('user_id', '=', Auth::id());
        		if($objService->count() > 0){
					// Delete all invited 
	        		$objInvited = InvitedUsers::where('service_id', '=', $varServiceRequest);
					if ($objInvited->count() > 0) {
						foreach($objInvited->get() as $isk=>$inv){
							$objInvited->delete();
						}
					}
	        	
	        		// Delete all documents
	        		$objServicesDoc = ServiceDocument::where('service_id', $varServiceRequest);
	        		if ($objServicesDoc->count() > 0) {
						foreach($objServicesDoc->get() as $k=>$v){
							$varFileName = $v->filename;
							$objServicesDoc->delete();
		        			$path = public_path().'/servicedocument/'.$varFileName;
		        			
		        			if (file_exists($path)) {
		            			unlink($path);
		        			}
						}
					}
					
					$objService->delete();
					return response()->json(true);
				}
        	}
        	else{
        		return response()->json(['errors' => ['Invalid' => array('Something went wrong.')]], 404);	
        	}	
        }
        catch(\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 404);
        }
    }
    
    /**
     * Search subscriber services
     *
     * @param  \App\Http\Requests\searchSubscriberServices  $request
     *
     * @return \Illuminate\Http\Response
    */
    public function searchSubscriberServices(Request $request){
    	
        try{

        	if($request->ajax()){ 
				$query =  $request->get('query');        		
				$objReturn  = array();
				$arrGetUserServices = array();
				if($query!=''){
					$objGetUserServices = Service::where('user_id',Auth::id())->where('service_title', 'like', '%'.$query.'%')->orderBy('created_at', 'DESC')->get()->toArray();
				}
				else{
					$objGetUserServices = Service::where('user_id',Auth::id())->orderBy('created_at', 'DESC')->get()->toArray();
				}

				foreach($objGetUserServices as $key=>$val){
					$varCountUsers = DB::table('service_invited_user')->where('service_id', $val['id'])->count();
					$arrGetUserServices[$key]['id'] = encrypt($val['id']);
					$arrGetUserServices[$key]['user_id'] = encrypt($val['user_id']);
					$arrGetUserServices[$key]['total_users'] = ($varCountUsers>0)?$varCountUsers:'&nbsp;&nbsp;';
					$arrGetUserServices[$key]['service_title'] = $val['service_title'];
					$arrGetUserServices[$key]['route'] = $val['route_id'];
					$arrGetUserServices[$key]['service_description'] = $val['service_description'];
					$arrGetUserServices[$key]['data_classification'] = $val['data_classification'];
					$arrGetUserServices[$key]['service_status'] = $val['service_status'];
					$arrGetUserServices[$key]['check_status'] = $val['check_status'];
				}

				$objReturn['shared_services'] = $arrGetUserServices;
				return response()->json(['data' => $objReturn], 200);
        	}
        	else{
        		return response()->json(['errors' => ['Invalid' => array('Something went wrong.')]], 404);	
        	}
        }
        catch(\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 404);
        }

    }


    /**
     * Search subscriber services
     *
     * @param  \App\Http\Requests\searchSubscriberServices  $request
     *
     * @return \Illuminate\Http\Response
    */
    public function searchUserServices(Request $request){
    	
        try{

        	if($request->ajax()){ 
				$query =  $request->get('query');        		
				$objReturn  = array();
				$arrGetUserServices = array();
				if($query!=''){
					
					$objGetUserServices = DB::table('service')
				    ->join('service_invited_user', 'service_invited_user.service_id', '=', 'service.id')
				    ->select('service.user_id AS service_user_id', 'service.id AS service_id', 'service_invited_user.access_type', 'service.service_title', 'service.service_description', 'service.data_classification', 'service.service_status', 'service.check_status')
				    ->where('service_invited_user.user_id', Auth::id())
				    ->where('service.service_title', 'like', '%'.$query.'%')
				    ->orderBy('service.created_at', 'DESC')->get()->toArray();
				}
				else{
					$objGetUserServices = DB::table('service')
				    ->join('service_invited_user', 'service_invited_user.service_id', '=', 'service.id')
				    ->select('service.id as service_id','service.user_id as service_user_id', 'service.id as service_id',  'service_invited_user.access_type', 'service.service_title', 'service.service_description', 'service.data_classification', 'service.service_status',  'service.check_status')
				    ->where('service_invited_user.user_id', Auth::id())
				    ->orderBy('service.created_at', 'DESC')->get()->toArray();
				}

				foreach($objGetUserServices as $key=>$val){
					$arrInfo = $this->getUsercompanyInfo($val->service_user_id);
					$arrGetUserServices[$key]['poc'] = $arrInfo['poc'];
					$arrGetUserServices[$key]['poc_email'] = $arrInfo['poc_email'];
					$arrGetUserServices[$key]['service_provider'] = $arrInfo['service_provider'];
					$arrGetUserServices[$key]['service_id'] = encrypt($val->service_id);
					$arrGetUserServices[$key]['route'] = $val->route_id;
					$arrGetUserServices[$key]['service_access'] = $val->access_type;
					$arrGetUserServices[$key]['subscriber_id'] = encrypt($val->service_user_id);
					$arrGetUserServices[$key]['service_title'] = $val->service_title;
					$arrGetUserServices[$key]['service_description'] = $val->service_description;
					$arrGetUserServices[$key]['data_classification'] = $val->data_classification;
					$arrGetUserServices[$key]['service_status'] = $val->service_status;
					$arrGetUserServices[$key]['check_status'] = $val->check_status;
				}

				$objReturn['shared_services_forme'] = $arrGetUserServices;
				return response()->json(['data' => $objReturn], 200);
        	}
        	else{
        		return response()->json(['errors' => ['Invalid' => array('Something went wrong.')]], 404);	
        	}
        }
        catch(\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 404);
        }

    }
}
