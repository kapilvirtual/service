<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\User;
use App\Model\Service;
use App\Model\ServiceDocument;
use App\Model\CompanyInfo;
use App\Model\CompanyContactInfo;
use App\Model\InvitedUsers;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\ServiceExistingMail;
use App\Mail\ServiceMail;
use Illuminate\Support\Facades\Mail;

class ServiceDetailController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
        if(Auth::guest())
	   		return view('admin.login');
    }


    public function index($id){
    	if($id){ 

    		$objGetUserServices = Service::where('route_id', $id)->orderBy('created_at', 'DESC')->first();
    		//echo $objGetUserServices->created_at;
    		//echo "<br>";
            //echo strtotime($objGetUserServices->created_at);
            //echo "<br>";
            //echo date('F d, Y h:s A ', strtotime($objGetUserServices->created_at));

            //die;
    		$objUser = User::where('id', Auth::id())->orderBy('created_at', 'DESC')->first();

    		$varCountServiceUsers = DB::table('service_invited_user')->where('service_id', $objGetUserServices->id)->count();
    		$varCountServiceUsers = ($varCountServiceUsers > 0)?$varCountServiceUsers:'';
    		$varServiceId = encrypt($objGetUserServices->id);

            $varCountServiceDocuments = DB::table('service_document')->where('service_id', $objGetUserServices->id)->count();
            $varCountServiceDocuments = ($varCountServiceDocuments > 0)?$varCountServiceDocuments:'';

    		return view('service-details', compact('objGetUserServices','varCountServiceUsers', 'varServiceId', 'objUser', 'varCountServiceDocuments' ));
    	}
    }

    /**
     * Store a invited users in storage.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function inviteUsers(Request $request){
    	try{ 
    		$returnObj = array();
            $arrInvitedExist = '';
            $arrResult = array();
            $arrGetInvitaqtions = array();
    	    if(isset($request->userdetails) && count($request->userdetails) > 0){ 
    	    	$varServiceId = decrypt($request->service);
		  		$request->userdetails = array_values(array_unique($request->userdetails));

		  		$objServicesCompanyInfo = Service::join('company_information', 'service.user_id', '=', 'company_information.user_id')
    				->join('company_contact_info', 'company_information.id', '=', 'company_contact_info.company_id')
    				->select('service.service_title', 'company_information.company_name', 'service.service_description')
    				->where('service.id', $varServiceId)
    				->first();
                $objInvited = InvitedUsers::join('users', 'users.id', '=', 'service_invited_user.user_id')->where('service_invited_user.service_id', $varServiceId)->select('users.email')->get()->toArray();
               
                $arrGetInvitaqtions[] = Auth::user()->email;

                if(count($objInvited) > 0){
                    foreach($objInvited as $k=>$v){ 
                        $arrGetInvitaqtions[] = $v['email'];
                    }
                    
                    $arrResult = array_intersect($request->userdetails, $arrGetInvitaqtions);

                    if(count($arrResult) > 0){
                        $arrInvitedExist = implode(' and ',$arrResult);
                    }

                }

                $arrDiff = array_diff($request->userdetails, $arrGetInvitaqtions);
                
                 
                if(count($arrDiff) > 0 ){
        	       	foreach($arrDiff as $key=>$val){
                        // check existing if already invited
                       	$useremail = $val;
                		$saveAccess = ($request->userrole == 'readonly')?'readonly':'both';
    					$varUserAccess = ($request->userrole == 'readonly')?'Read Only':'Read/Write';

    					if (User::where('email', '=', $useremail)->count() > 0) {
    						$varUserId = User::where('email', $useremail)->value('id');
    						$info =  array('title' => $objServicesCompanyInfo->service_title, 'company' => $objServicesCompanyInfo->company_name, 'description' => $objServicesCompanyInfo->service_description, 'accesstype' =>$varUserAccess);
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

    						$info =  array('title' => $objServicesCompanyInfo->service_title, 'company' => $objServicesCompanyInfo->company_name, 'description' => $objServicesCompanyInfo->service_description, 'emailaddress'=> $useremail, 'accesstype' =>$varUserAccess, 'token' =>$varToken);

    						Mail::to($useremail)->send(new ServiceMail($info));	
    					}

    					$objUserInvited = new InvitedUsers;
    					$objUserInvited->service_id = $varServiceId;
    					$objUserInvited->user_id = $varUserId;
    					$objUserInvited->access_type = $saveAccess;
    					$objUserInvited->save();
                	}
                }

                // count Total invited users
                $objInvited = InvitedUsers::join('users', 'service_invited_user.user_id', '=', 'users.id')
                ->join('service','service_invited_user.service_id','service.id')
                ->select(DB::raw("DATE_FORMAT(service_invited_user.created_at, '%M %d, %Y %h:%i %p') as formatted_date"), "service_invited_user.service_id", "service_invited_user.access_type", "users.name", "users.email", "service_invited_user.id as service_invited_id")
                ->where('service_invited_user.service_id', $varServiceId);
               	$varCntServices = $objInvited->count();
                $varObjUserList = $objInvited->orderBy('service_invited_user.created_at', 'DESC')->get();

                $returnObj['countUsers'] = $varCntServices;
                $returnObj['userList'] = $varObjUserList;
                $returnObj['existingusercnt'] = count($arrResult);
                $returnObj['existingusersrepeted'] = $arrInvitedExist;
                $returnObj['newusers'] = count($arrDiff) ;

                return response()->json(['data' => $returnObj], 200);
            }
    	}
    	catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


 	/**
     * Get Service id and return the user invited list.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getServiceInvitedUserList(Request $request){
    	$returnObj = array();
    	try{
    		$varServiceId = decrypt($request->service);
    		if($varServiceId > 0){
    			$objInvited = InvitedUsers::join('users', 'service_invited_user.user_id', '=', 'users.id')
            	->join('service','service_invited_user.service_id','service.id')
            	->select(DB::raw("DATE_FORMAT(service_invited_user.created_at, '%M %d, %Y %h:%i %p') as formatted_date"), "service_invited_user.service_id", "service_invited_user.access_type", "users.name", "users.email", "service_invited_user.id as service_invited_id")
            	->where('service_invited_user.service_id', $varServiceId);
	           	$varCntServices = $objInvited->count(); 	
	            $varObjUserList = $objInvited->orderBy('service_invited_user.created_at', 'DESC')->get();

	            $returnObj['countUsers'] = $varCntServices;
	            $returnObj['userList'] = $varObjUserList;
	            return response()->json(['data' => $returnObj], 200);
    		}
 			return response()->json(['error' => 'Something went wrong please try again.'], 422);
    	}
    	catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Get invited route id and update the user access for service
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserWithAccess(Request $request){
    	try{
    		if(isset($request->update_request) && $request->update_request > 0){
    			$arrDocs = InvitedUsers::where('id', $request->update_request)->update(['access_type'=>$request->set]);
    			return response()->json(['data' => true], 200);
    		}
    	}
    	catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Get Service route id and update the user access for service
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function removeUserWithAccess(Request $request){
    	try{
    		if(isset($request->request_id) && $request->request_id > 0){

    			$objInvited = InvitedUsers::join('service', 'service_invited_user.service_id', '=', 'service.id')
            	->select('service.user_id')
				->where('service_invited_user.id', $request->request_id)->first();
                
				if($objInvited->user_id == Auth::id()){
				 	InvitedUsers::where('id', $request->request_id)->delete();
				 	return response()->json(['data' => true], 200);
				}
				return response()->json(['data' => false], 404);
    		}
    	}
    	catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Check existing user
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
    */
    public function checkExistingInvitedUser(Request $request){
        $arrGetInvitaqtions = array();
        if(count($request->userdetails) > 0){
            $varServiceID = decrypt($request->service);
            $objInvited = InvitedUsers::join('users', 'users.id', '=', 'service_invited_user.user_id')->where('service_invited_user.service_id', $varServiceID)->select('users.email')->get()->toArray();
            if(count($objInvited) > 0){
                foreach($objInvited as $k=>$v){ 
                    $arrGetInvitaqtions[] = $v['email'];
                }
                
                $arrResult = array_intersect($request->userdetails, $arrGetInvitaqtions);
                if(count($arrResult) > 0){
                    return response()->json(['data' => false], 200);
                }
            } 
        }
        return response()->json(['data' => true], 200); 
    }

    public function getServiceDocList(Request $request){
        DB::beginTransaction();
        try{
            
            
            /*$varInvitedUsersEmail = array('myoneemail@esomething.com', 'myother@esomething.com', 'myother2@esomething.com');

            foreach($varInvitedUsersEmail as $toemail){

            $varAttachFilePath =  public_path('servicedocument').'/1537184968384_2018-9-17_Admit_Card.pdf';
            $varFilenameOrg= 'kapiol.pdf';
            $varTitle = 'My title';
            $varMimeType = 'application/pdf';
           
            Mail::send('emails.ServiceDocumentUploadMail', [
                'user' => Auth::user()->name,
                'service_title' => 'Service title',
                'document_name' => 'Document name',
                'upload_document' => 'Upload document'
            ], function ($message) use ($request, $toemail, $varAttachFilePath, $varFilenameOrg,$varMimeType) {
                $message->from('getsecured@service.com'); 
                $message->to($toemail)
                        ->subject('Notification for uploaded document')
                        ->replyTo('norepaly@service.com')
                        ->attach($varAttachFilePath, [
                            'as' => $varFilenameOrg, 
                            'mime' => $varMimeType
                        ]);
                $message->getSwiftMessage();
            });
        }
            die;*/







            $file = $request->file('upload_document');

            $arrInvitedUserEmail = array();
            $varServiceInfoID = decrypt($request->service_info);
            $varServiceTitle = Service::where('id', $varServiceInfoID)->value('service_title');

            $filename = $file->getClientOriginalName();
            $extension  = $file->getClientOriginalExtension();
            $varMimeType = $file->getClientMimeType();

            $validator = Validator::make($request->all(), [
                'upload_document' => 'required|mimes:pdf,doc,docx,odt,ppt,xls,pptx,xlsx,jpg,jpeg,txt,rtf,txt|max:50000'
            ]);

            if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()], 422);
            }

            $varOrgFileName = $filename;
            $varThumbNailfilename = time().'_'.date('Ymd').'_thumbnail_'.$filename;
            $varFileNameOrg = time().'_'.date('Ymd').'_org_'.$filename;
            $destinationPath = public_path('servicedocument');
            
            $supported_image = array('gif','jpg','jpeg','png','bmp');
                if (in_array($extension, $supported_image)) {
                    $destinationFilePathThumbnail = public_path('servicedocument/thumbnail');
                    $img = Image::make($file->getRealPath());
                    $img->resize(125, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationFilePathThumbnail.'/'.$varThumbNailfilename);
                }

            $file->move($destinationPath, $varFileNameOrg);

            $imageUpload = new ServiceDocument();
            $imageUpload->service_id = $varServiceInfoID;
            $imageUpload->user_id = Auth::id();
            $imageUpload->filename = $varFileNameOrg;
            $imageUpload->org_file_name = $varOrgFileName;
            $imageUpload->save();
  

            $objInvited = InvitedUsers::join('users', 'users.id', '=', 'service_invited_user.user_id')->where('service_invited_user.service_id', $varServiceInfoID)->select('users.email');
            $varCountUser = $objInvited->count();
            $arrGetUsers = $objInvited->get()->toArray();
            
            $varAttachFilePath =  public_path('servicedocument').'/'.$varFileNameOrg;
            if($varCountUser > 0){
                foreach($arrGetUsers as $arr){
                    foreach($arr as $email){
                        Mail::send('emails.ServiceDocumentUploadMail', [
                            'user' => Auth::user()->name,
                            'service_title' => $varServiceTitle,
                            'document_name' => $varOrgFileName,
                            'upload_document' => $varFileNameOrg
                        ], function ($message) use ($request, $email, $varAttachFilePath, $varOrgFileName, $varMimeType) {
                            $message->from('getsecured@service.com'); 
                            $message->to($email)
                                    ->subject('Notification for uploaded document')
                                    ->replyTo('norepaly@service.com')
                                    ->attach($varAttachFilePath, [
                                        'as' => $varOrgFileName, 
                                        'mime' => $varMimeType
                                    ]);
                            $message->getSwiftMessage();
                        });    
                    }
                }
            }
            
            // count Total invited users
            $objInvited = ServiceDocument::join('users', 'service_document.user_id', '=', 'users.id')
            ->select(DB::raw("DATE_FORMAT(service_document.created_at, '%M %d, %Y %h:%i %p') as formatted_date"), "service_document.service_id", "service_document.service_id",  "users.name", "service_document.filename","service_document.org_file_name","service_document.id as documentId")
            ->where('service_document.service_id', $varServiceInfoID);
            $varCntDocuments = $objInvited->count();
            $varObjDocumentList = $objInvited->orderBy('service_document.created_at', 'DESC')->get();

            $returnObj['countDocuments'] = $varCntDocuments;
            $returnObj['documentList'] = $varObjDocumentList;
            DB::commit();
            return response()->json(['data' => $returnObj], 200);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    public function getServiceDocumentList(Request $request){
        $returnObj = array();
        try{
            $varServiceId = decrypt($request->service);
            if($varServiceId > 0){
                $objInvited = ServiceDocument::join('users', 'service_document.user_id', '=', 'users.id')
                    ->select(DB::raw("DATE_FORMAT(service_document.created_at, '%M %d, %Y %h:%i %p') as formatted_date"), "service_document.service_id",  "users.name", "service_document.filename", "service_document.org_file_name", "service_document.id as documentId")
                    ->where('service_document.service_id', $varServiceId);
                    $varCntDocuments = $objInvited->count();
                    $varObjDocumentList = $objInvited->orderBy('service_document.created_at', 'DESC')->get();

                $returnObj['countDocuments'] = $varCntDocuments;
                $returnObj['documentList'] = $varObjDocumentList;

                return response()->json(['data' => $returnObj], 200);
            }
            return response()->json(['error' => 'Something went wrong please try again.'], 422);
        }
        catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

}	







