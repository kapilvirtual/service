@extends('layouts.header')
@section('content')

<div id="loadingDiv"></div>

<section class="service-detail">
		<div class="container">
			<div class="service-inner">

				<div class="navigation-bar">
					<h3><i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;{{$objGetUserServices->service_title}}</h3>
					<ul class="page-setting-list pull-right">
						<!--<li>
							<select class="form-control">
								<option>Options</option>
							</select>
						</li>-->
						<li><span class="count_service_user">{{$varCountServiceUsers}} </span>
							<i class="fa fa-users btn" id="InviteUserTitle" title="Invite User" aria-hidden="true"></i>
						</li>
						<li><span class="count_document_service">{{$varCountServiceDocuments}} </span>
							<i class="fa fa-file btn" id="ServiceDocuments" title="Service Document Upload" aria-hidden="true"></i>
						</li>
						<li><i class="fa fa-paint-brush" aria-hidden="true"></i></li>
						<li><i class="fa fa-cog" aria-hidden="true"></i></li>
					</ul>
				</div>
				<div class="col-md-12">
					<div class="detail-row">
						<h3>Service Description <a href="javascript:void(0);" id="service_description_title"  title="Change Description" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>
						<div class="updated-on"><strong>160 KB</strong> updated on September 17, 2018</div>
						<p>{{$objGetUserServices->service_description}}</p>
					</div>
					<div class="detail-row">
						<h3>Service Validation Date <a href="javascript:void(0);" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>
						<p>{{$objGetUserServices->validation_date}}</p>
					</div>
					<div class="detail-row">
						<h3>Applicable regulations and standards <a href="javascript:void(0);" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>
						<p>{{$objGetUserServices->regulations_standard}}</p>
					</div>
					<div class="detail-row">
						<h3>Data Classification <a href="javascript:void(0);" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>
						<p><strong>{{ucfirst($objGetUserServices->data_classification)}}</strong></p>
					</div>
					<div class="detail-row">
						<h3>Business controls <a href="javascript:void(0);" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>
						<p>{{$objGetUserServices->business_controls}}</p>
					</div>
					<div class="detail-row">
						<h3>Data security controls <a href="javascript:void(0);" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>
						<p>{{$objGetUserServices->security_controls}}</p>
					</div>

				</div>			

			</div>
			
		</div>
	</section>
<!-- service Section -->
<div class="modal fade" id="userInviteModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog mymodel-dialog">
    <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <h4 class="modal-title button-title" >Invite Users to "{{$objGetUserServices->service_title}}"</h4>
	    </div>
      	<div class="modal-body user-invite-modal">
      		<div class="alert alert-danger alert-dismissible">
			    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			    <div></div>
			</div>
         	<div class="form-group">
                <textarea class="form-control" rows="4" name="user_invite_box" id="user_invite_box" placeholder="Enter email addresses separated by commas."></textarea>
            </div>
            <div class="row invite-section">
            	<div class="col-sm-12 invite-wrapper">
            		
            		<button type="button" class="btn btn-default invite-btn" data-service="{{$varServiceId}}">Invite</button>
	            		<select class="invite-option" name="user_role" id="user_role">
	            			<optgroup label="Select User Role">
	            				<option value="readonly">Read</option>
								<option value="both">Read/Write</option>		
							</optgroup>
						</select>
            	</div>            	
            	<div class="clearfix"></div>
            </div>
            <div class="form-group">
	           	<div class="row user-row">
	      			<div class="profile col-sm-1"><img alt="user_img" src="{{asset('/images/user_demo.png')}}"></div>
	      			<div class="details col-sm-8">
	        			<span>{{$objUser->name}} {{$objUser->email}}</span>
	        			<div class="meta">
	          				<em class="timestamp">{{date('F d, Y h:s A ', strtotime($objGetUserServices->created_at)) }}</em>
	        			</div>
	      			</div>
	      			<div class="col-sm-3">
	      				<ul class="list-inline">
		      				<li>
								<select name="service-user" id="service-user" disabled>
									<optgroup label="Administrator">
										<option value="readonly">Administrator</option>
									</optgroup>

								</select>
							</li>
		       			 	<li class="js-delete text-right">
		       			 		<i class="fa fa-question-circle" aria-hidden="true"></i>
		       			 	</li>
	       				</ul>
	     			</div>
				</div>
			</div>
			<div class="invite-users-section">
            	<div class="col-sm-12 all-users">All Users</div>            	
            	<div class="clearfix"></div>
            </div>
            <div class="repet-users"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="userServiceDocumentModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog mymodel-dialog">
    <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <h4 class="modal-title button-title" >Upload document to "{{$objGetUserServices->service_title}}"</h4>
	    </div>
      	<div class="modal-body user-invite-modal">
      		<div class="alert alert-danger alert-dismissible">
			    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  </div>	
        <div class="form-group">
	        <div class="row user-row">
	      		<div class="profile col-sm-1"><img alt="user_img" src="{{asset('/images/user_demo.png')}}"></div>
	      		<div class="details col-sm-8">
	        		<span>{{$objUser->name}} {{$objUser->email}}</span>
	        	  <div class="meta">
	          		<em class="timestamp">{{date('F d, Y h:s A ', strtotime($objGetUserServices->created_at)) }}</em>
	        		</div>
	      		</div>
	      		<div class="col-sm-3">
	      			<ul class="list-inline">
		      			<li>
    							<select name="service-user" id="service-user" disabled>
    								<optgroup label="Administrator">
    								  <option value="readonly">Administrator</option>
    				  			</optgroup>
    							</select>
							  </li>
		       			<li class="js-delete text-right">
		       				<i class="fa fa-question-circle" aria-hidden="true"></i>
		       			</li>
	       			</ul>
	     			</div>
				  </div>
			  </div>
        <div class="row invite-section">
              <div class="col-sm-4 invite-wrapper">
                <form action="{{ route('user.invite') }}" method="post"  id="Ajaxform" enctype="multipart/form-data">
                  <input type="file" name="upload_document" id="service_document">
                  <input type="hidden" name="service_info"  value="{{$varServiceId}}">
                </form>       
              </div> 
              <div class="col-sm-8 invite-wrapper"><button type="button" class="btn btn-default" id="upload-service-doc">Upload</button></div>
              <div class="clearfix"></div>
             <?php /* <div class="clearfix"></div>
              <div class="progress">
                  <div class="bar"></div >
                  <div class="percent">0%</div >
              </div>
              */ ?>
          </div>
			  <div class="invite-users-section">
         	<div class="col-sm-12 all-users">All Documents</div>            	
           	<div class="clearfix"></div>
          </div>
          <div class="load-documents"></div>
        </div>
    </div>
  </div>
</div>
@stop
@section('javascript') 

<script>
Dropzone.autoDiscover = false;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
	$("#loadingDiv").hide();

	 	function validateEmail(sEmail){
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;    
            
            if (filter.test(sEmail)) {
                return true;
            }
            else {
                return false;
            }
        } 

     	/*
        	Function for count Duplicates values from an array
        */

        function hasDuplicates(array) {
            var valuesSoFar = Object.create(null);
                for (var i = 0; i < array.length; ++i) {
                    var value = array[i];

                    if (value in valuesSoFar) {
                        return true;
                    }
                    valuesSoFar[value] = true;
                }
            return false;
        }

        /*
            Function for simplyfy array and count with the sub function for duplicates values
        */
        function duplicateCount(arr){
            var getArr = [];
            var email;
             $.each(arr, function (i) {
               var email = arr[i].useremails;
               getArr.push(email);
            });
            return hasDuplicates(getArr);
        }

        /*
			    Function for listing html for invited user list
        */
        function getInvitedServiceUserList(data){
    				var objUserList = data.data;
    				$(".repet-users").html('');
    				//console.log(objUserList.userList);
    				var varDivInvitedUsers = '';
            	$.each(objUserList.userList, function (i) {
                  varDivInvitedUsers += '<div class="form-group users-row" id="user-'+objUserList.userList[i].service_invited_id+'"><div class="row"><div class="profile col-sm-1"><img alt="user_image" src="{{asset('/images/user_demo.png')}}"></div><div class="details col-sm-8"><span data-profile-url="#" aria-describedby="ui-tooltip-10">'+objUserList.userList[i].name+' '+objUserList.userList[i].email+'</span><div class="meta"><em class="timestamp">'+objUserList.userList[i].formatted_date+'</em></div></div><div class="col-sm-3"><ul class="list-inline"><li><select name="access_type" title="Change access for user." style="width: 110px;" service_invitedid="'+objUserList.userList[i].service_invited_id+'" class="update_user_role"><optgroup label="User Role">';                 		
                    
                    if(objUserList.userList[i].access_type == 'readonly'){
                 			varDivInvitedUsers += '<option value="readonly" selected >Read</option><option value="both" >Read/Write</option>';	   
                 		}
                 		else if(objUserList.userList[i].access_type == 'both'){
                 			varDivInvitedUsers += '<option value="readonly">Read</option><option value="both" selected >Read/Write</option>';	   
                 		}

                    varDivInvitedUsers +='</optgroup></select></li><li class="js-delete text-right"  title="Remove user from your service" data-id="'+objUserList.userList[i].service_invited_id+'"><i class="fa fa-trash btn" aria-hidden="true"></i></li></ul></div></div></div>';
              });

            	$(".repet-users").html(varDivInvitedUsers);
        }

function getFileextensionWithIcon(filename){
    var ext = filename.split('.').pop();

    var icon = '<i class="fa fa-file-o" style="font-size:36px"></i>';
    switch(ext) {
        case "png":
          icon = '<i class="fa fa-file-picture-o" style="font-size:36px"></i>';
        break;
        case "gif":
          icon = '<i class="fa fa-file-picture-o" style="font-size:36px"></i>';
        break;
        case "jpg":
          icon = '<i class="fa fa-file-picture-o" style="font-size:36px"></i>';
        break;
        case "jpeg":
          icon = '<i class="fa fa-file-picture-o" style="font-size:36px"></i>';
        break;
        case "pdf":
          icon = '<i class="fa fa-file-pdf-o" style="font-size:36px"></i>';
        break;
        case "rtf":
          icon = '<i class="fa fa-file-text-o" style="font-size:36px"></i>';
        break;
        case "xls":
          icon = '<i class="fa fa-file-excel-o" style="font-size:36px"></i>';
        break;
        case "xlsx":
          icon = '<i class="fa fa-file-excel-o" style="font-size:36px"></i>';
        break;
        case "doc":
          icon = '<i class="fa fa-file-word-o" style="font-size:36px"></i>';
        break;
        case "docx":
          icon = '<i class="fa fa-file-word-o" style="font-size:36px"></i>';
        break;
        case "odt":
          icon = '<i class="fa fa-file-word-o" style="font-size:36px"></i>';
        break;
        case "txt":
          icon = '<i class="fa fa-file-text-o" style="font-size:36px"></i>';
        break;
        default:
          icon = '<i class="fa fa-file-o" style="font-size:36px"></i>';
      }
      return icon;
  }
    /*
			Function for listing html for invited user list
    */
    function getInvitedServiceDocumentList(data){
			var objDocumentList = data.data;
			$(".load-documents").html('');
		
      var varDivInvitedUsers = '';
    	$.each(objDocumentList.documentList, function (i) {
        var filename = objDocumentList.documentList[i].filename;
            var varFileIcon = getFileextensionWithIcon(filename);
            varDivInvitedUsers += '<div class="form-group users-row" id="user-'+objDocumentList.documentList[i].documentId+'"><div class="row"><div class="profile col-sm-1">'+varFileIcon+'</div><div class="details col-sm-8"><span data-profile-url="https://ws.onehub.com/user_profiles/29c6e1843c8f97b5cf0a70d351447135" aria-describedby="ui-tooltip-10"><b>'+objDocumentList.documentList[i].org_file_name+'<b></span><div class="meta"><em class="timestamp">'+objDocumentList.documentList[i].formatted_date+'</em></div></div><div class="col-sm-3"><ul class="list-inline"><li class="js-delete text-right" title="Download" data-id="'+objDocumentList.documentList[i].documentId+'"><i class="fa fa-download btn" aria-hidden="true"></i></li><li class="js-delete text-right" title="Remove user from your service" data-id="'+objDocumentList.documentList[i].documentId+'"><i class="fa fa-trash btn" aria-hidden="true"></i></li></ul></div></div></div>';
        });
    	$(".load-documents").html(varDivInvitedUsers);
    }


	$('body').on('click', '.invite-btn', function(e) { 
        e.preventDefault();
        var userGlobal = {};
        var k = 0;
        var available = false;
    		var users = $('#user_invite_box').val();
    		userGlobal['service'] = $(this).data("service");
    		userGlobal['userrole'] = $('#user_role').val();
    		//$(this).prop("disabled", true);
    		var arrUsers = users.split(",").map(function(item) {
    		  return item.trim();
    		});

		console.log(arrUsers[0]);
		if (typeof arrUsers !== 'undefined' && arrUsers[0]==''){
			var arrUsers = {};
		}
	
		var arrInvalidEmail = [];
		var varAlertErrorMessage = 'Please enter users email addresses separated with(,) commas to invite users.';
		    if(arrUsers.length > 0){ 
          var emailcheck = false;
          $.each(arrUsers, function (i) {
              if(!validateEmail(arrUsers[i])){
              	arrInvalidEmail[i] = arrUsers[i];
                	emailcheck =  true;
              }
          });

          if(arrInvalidEmail.length > 0){ 
          		var userEmail = '';
    					$.each(arrInvalidEmail, function (i) {
    						userEmail += arrInvalidEmail[i]+', ';
    					});
    					varAlertErrorMessage =  'Please enter valid email address: '+userEmail;
          }

          if(emailcheck){
        		swal({title: "Error!",  text: varAlertErrorMessage,  icon: "error",    dangerMode: true, closeOnClickOutside: false,  closeOnEsc: false,cancel: {visible: false}});
        		$(this).prop("disabled", false);
        		return false;
      	  }

                //if(duplicateCount(arrUsers)){
                //    swal({title: "Warning!", text: "Duplicate users found for invitation.", icon: "warning", dangerMode: true,
                //    closeOnClickOutside: false, closeOnEsc: false, cancel:false});
                //}
        }
        else{
        	swal({title: "Warning!", text: varAlertErrorMessage, icon: "warning", dangerMode: true,
                closeOnClickOutside: false, closeOnEsc: false, cancel:false});
        	$(this).prop("disabled", false);
        	return false;
        }
        userGlobal['userdetails'] =  arrUsers;

      /*  $('input[name^="useremail[]"]').each(function() {
            var getEmail = $(this).val();    
            if(getEmail !== null && getEmail !== '') {
                var varGetID = $(this).attr("id");
                var arrResult = varGetID.split('_');
                var varInputNumber = arrResult[1];
                var varAccessVal = $('input[name^="access_'+varInputNumber+'"]:checked').val();
                userDetails.push({['useremails']: getEmail, ['useraccess']:varAccessVal});
                varGlobals['userdetails'] = userDetails;
                k++;
            }
        });

        if(userDetails.length > 0){ 
            var emailcheck = false;
            $.each(userDetails, function (i) {
                if(!validateEmail(userDetails[i].useremails)){
                  emailcheck =  true;
                }
            });

            if(duplicateCount(userDetails)){
                swal({title: "Error!", text: "Duplicate users found for invitation.", icon: "error", buttons: false, dangerMode: true,
                closeOnClickOutside: false, closeOnEsc: false, timer: 2000,});
                return false;
            }
        }

        if(emailcheck){
          swal({title: "Error!",  text: "Please enter valid email address.",  icon: "error",   buttons: false, dangerMode: true,
            closeOnClickOutside: false,  closeOnEsc: false,  timer: 2000});
          return false;
        }
        */

    	$("#loadingDiv").show();
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ route("user.invite") }}',
            data: userGlobal,
            success: function (data){
            	getInvitedServiceUserList(data);
                $("#loadingDiv").hide();
                $(".count_service_user").text(data.data.countUsers);
                $(this).prop("disabled", false);
                var messageWarning = '';
                if(data.data.existingusercnt > 0){
                	messageWarning = data.data.existingusersrepeted+' have already been invited.';
                	if(data.data.newusers > 0){
                		messageWarning += ' Other emails were invited successfully.';
                	}
                	$('.alert-dismissible').show();
                	$('.alert-dismissible div').text(messageWarning);
                }
                else{
                	swal({
		                title: "Success!",
		                text: "Your invitation has been sent successfully!",
		                icon: "success",
		                dangerMode: false,
		                closeOnClickOutside: false,
		                closeOnEsc: false,
              		});  
                }
                $('#user_invite_box').val('');
            },
            error: function(e) {
              $("#loadingDiv").hide();
              $(this).prop("disabled", false);
              swal("Error!", "Something went wrong.", "error");
            }
        });
        $('#submit_service').prop("disabled", true);
    });
  

      function ajaxFormSubmit(form, callback) {

        var formData = new FormData($(form)[0]);
        $("#loadingDiv").show();
        $.ajax({
            url: '{{ route("service.service-document-list") }}',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            datatype: 'json',
            beforeSend: function() {
                // do some loading options
            },
            success: function(data) {
              getInvitedServiceDocumentList(data);
              $("#service_document").val('');
              $("#loadingDiv").hide(); 
              swal({
                title: "Success!",
                text: "your documents has been successfully uploaded!",
                icon: "success",
                dangerMode: false,
                closeOnClickOutside: false,
                closeOnEsc: false,
                timer: 2000
              });
            },
            complete: function() {
              // success alerts
            },
            error: function(xhr, status, error) {

              var response = JSON.parse(xhr.responseText);

              var errorsHtml = '';
              $.each( response.errors, function( key, value) {
                errorsHtml += value+'!<br>';
              });
             
              var elem = document.createElement("div");
              elem.innerHTML = errorsHtml;

              swal({
                title: "Error!",
                content: elem,
                icon: "error"
              });
            }

        });
      }

    $('body').on('click', '#upload-service-doc', function(e) {
      var file =$("#service_document")[0].files[0];
      var varFileValCheck = $("#service_document").val();
      if(varFileValCheck === ""){
        swal("Error!", "Please select file to uplaod.", "error");
        return false;
      }
      else{
        var varFileName = $("#service_document").val().split('\\').pop();
        var extension = varFileName.split('.').pop();
          if (/(bat|exe|cmd|sh|php|pl|cgi|386|dll|com|torrent|js|app|jar|pif|vb|vbscript|wsf|asp|cer|csr|jsp|drv|sys|ade|adp|bas|chm|cpl|crt|csh|fxp|hlp|hta|inf|ins|isp|jse|htaccess|htpasswd|ksh|lnk|mdb|mde|mdt|mdw|msc|msi|msp|mst|ops|pcd|prg|reg|scr|sct|shb|shs|url|vbe|vbs|wsc|wsf|wsh)$/ig.test(extension)) {
            var extension = "Invalid file type:-   ."+extension +" is not allowed.";
            swal("Error!", extension , "error");
            return false;
          }
      }
      // var ext = filename.split('.').pop();    
      ajaxFormSubmit('#Ajaxform',function(output){
        console.log('upload');
      }); 
    });


    $('body').on('click', '#UploadDocument', function(e) {
      var bar = $('.bar');
      var percent = $('.percent');
      var status = $('#status');

   
    var file =$("#service_document")[0].files[0];
     var filename = $("#service_document").val();


    //var formdata = new FormData();
    //formData.append("file1", file);

    var filename = $("#file").val();

        $.ajax({
            type: "POST",
            url: '{{ route("service.service-document-list") }}',
            enctype: 'multipart/form-data',
            data: {
                file: filename
            },
            success: function () {
                alert("Data Uploaded: ");
            }
        });



  /*  $.ajax({
     /* xhr: function() {
        var xhr = new window.XMLHttpRequest();

        xhr.upload.addEventListener("progress", function(evt) {
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            console.log(percentComplete);

            if (percentComplete === 100) {

            }

          }
        }, false);
        return xhr;
      },
      url: '{{ route("service.service-document-list") }}',
      type: "POST",
      data: file,
      enctype: 'multipart/form-data',
      success: function(result) {
        console.log(result);
      }
    });*/
  });



	$('body').on('click', '#InviteUserTitle', function(e) {
		$('#userInviteModel').modal({
        	backdrop: 'static',
        	fadeDuration: 1000,
        	fadeDelay: 0.50
     	}); 
	});

	$('body').on('click', '#ServiceDocuments', function(e) {
		$('#userServiceDocumentModel').modal({
        	backdrop: 'static',
        	fadeDuration: 1000,
        	fadeDelay: 0.50
     	}); 
	});

	$('#userInviteModel').on('shown.bs.modal', function (e) {  console.log('rrrrrr');
		var service = $('.invite-btn').data("service");
		$(".repet-users").html('');
		$('.alert-dismissible').hide();
		$('#user_invite_box').val('');
		arrGlobal = {};
		arrGlobal['service'] = $('.invite-btn').data("service");
		if(service!=''){
			$.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ route("service.user-list") }}',
            data: arrGlobal,
            success: function (data){
            	  getInvitedServiceUserList(data);         
            },
            error: function(e) {
              $("#loadingDiv").hide();
              $(this).prop("disabled", false);
              swal("Error!", "Something went wrong.", "error");
            }
        });
		}
	});

	$('#userServiceDocumentModel').on('shown.bs.modal', function (e) { 
		var service = $('.invite-btn').data("service");
		$(".load-documents").html('');
		$('.alert-dismissible').hide();
		$('#user_invite_box').val('');
		arrGlobal = {};
		arrGlobal['service'] = $('.invite-btn').data("service");
		if(service!=''){
			$.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ route("service.document-list") }}',
            data: arrGlobal,
            success: function (data){ console.log(data);
            	  getInvitedServiceDocumentList(data);         
            },
            error: function(e) {
              $("#loadingDiv").hide();
              $(this).prop("disabled", false);
              swal("Error!", "Something went wrong.", "error");
            }
        });

		}
	});
	/*
		Update user access on service by subscriber
	*/
	$('body').on('change', '.update_user_role', function(e) {
			arrGlobal = {};
			arrGlobal['update_request'] = $(this).attr('service_invitedid');
			arrGlobal['set'] = $(this).val();
			$.ajax({
	            headers: {
	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            type: 'POST',
	            url: '{{ route("update.user-access") }}',
	            data: arrGlobal,
	            success: function (data){
					var result = data.data;
					if(result){
						swal({
              title: "Success!",
              text: "Your request has been completed successfully!",
              icon: "success",
              dangerMode: false,
              closeOnClickOutside: false,
              closeOnEsc: false,
              timer: 2000
        		});
					}            
	            },
	            error: function(e) {
	              swal("Error!", "Something went wrong.", "error");
	            }
       	 	});
	});

	/*
		Remove invited user  on service by subscriber
	*/
	$('body').on('click', '.js-delete', function(e) {
		arrGlobal = {};
		arrGlobal['request_id'] = $(this).data('id');
		var getID = $(this).data('id');
		var varTotalCntUser = $('.count_service_user').text();

			$.ajax({
	            headers: {
	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            type: 'POST',
	            url: '{{ route("remove.user-access") }}',
	            data: arrGlobal,
	            success: function (data){ 
					var result = data.data;
					
					if(result){
						swal({
			                title: "Success!",
			                text: "Your request has been completed successfully!",
			                icon: "success",
			                dangerMode: false,
			                closeOnClickOutside: false,
			                closeOnEsc: false,
			                timer: 2000
	              		});

						if(varTotalCntUser!=''){
							varTotalCntUser = parseInt(varTotalCntUser) - 1;
							if(varTotalCntUser >=1 ){	
								$('.count_service_user').text(varTotalCntUser);
							}
							else{
								$('.count_service_user').text('');	
							}
						}
	        			$('#user-'+getID).remove();
					}
					else{
						 swal("Error!", "Something went wrong.", "error");
					}            
	            },
	            error: function(e) {
	              swal("Error!", "Something went wrong.", "error");
	            }
       		});
		
	});

 	$("#service_description_title").tooltip();
 	$("#InviteUserTitle").tooltip();
}); 
</script>
@endsection
