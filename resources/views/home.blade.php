@extends('layouts.header')
@section('content')
<style>
  .quadrat {
 
  -webkit-animation: NAME-YOUR-ANIMATION 2s infinite;  /* Safari 4+ */
  -moz-animation: NAME-YOUR-ANIMATION 2s infinite;  /* Fx 5+ */
  -o-animation: NAME-YOUR-ANIMATION 2s infinite;  /* Opera 12+ */
  animation: NAME-YOUR-ANIMATION 2s infinite;  /* IE 10+, Fx 29+ */
}

@-webkit-keyframes NAME-YOUR-ANIMATION {
  0%, 49% {
    
    
  }
  50%, 100% {
    background-color: #e50000;
    
  }
}
</style>
<div id="loadingDiv"></div>
<!-- service Section -->
  <section class="service_sect">
    <div class="container">
      <div class="row" id="company_profile_contact_info" style="display: none;">
        <div class="col-xs-12 table-responsive">
          <table class="table table-bordered service_sect_table">
            <tr>
              <td><img src="" alt="" id="company_profile_logo" ></td>
              <td><h2>Company Profile</h2></td>
            </tr>
            <tr>
              <td><h3>Company Information</h3></td>
              <td><h3>Contact Information</h3></td>
            </tr>
            <tr>
              <td class="np">
                <table class="table">
                  <tr>
                    <td  style="width: 100px;" class="nb"><b>Name :</b></td>
                    <td class="nb" id="dash_company_name"></td>
                  </tr>
                  <tr>
                    <td><b>Website :</b></td>
                    <td id="dash_company_website_name"></td>
                  </tr>
                  <tr>
                    <td><b>Address :</b></td>
                    <td id="dash_company_address"></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="np">
                      <table class="table">
                        <tr> 
                          <td class="nb"><b>City :</b></td>
                          <td class="nb" id="dash_company_city"></td>
                          <td class="nb"><b>State :</b></td>
                          <td class="nb"></td>
                          <td class="nb" id="dash_company_state"><b>Zip :</b></td>
                          <td class="nb" id="dash_company_zip"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td  class="np">
                <table class="table">
                  <tr>
                    <td style=" width: 205px;" class="nb" ><b>Name :</b></td>
                    <td class="nb" id="dash_cc_name" ></td>
                  </tr>
                  <tr>
                    <td class="np" colspan="2">
                      <table class="table">
                        <tr> 
                          <td class="nb" style=" width: 160px;" ><b>Phone Number :</b></td>
                          <td class="nb" id="dash_cc_phone"></td>
                          <td class="nb" ><b>ext.</b></td>
                          <td class="nb" id="dash_cc_ext"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Email Address :</b></td>
                    <td id="dash_cc_email_address"></td>
                  </tr>
                  <tr>
                    <td><b>Alt Contact (Name &#38; Email):</b></td>
                    <td id="dash_cc_name_email"></td>
                  </tr>
                  
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </section>
<section class="services_tab_bx">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-3">
        <div class="services_tabs">
          <h4>Services</h4>
            <ul class="nav nav-tabs">
              <li class="active" ><a data-toggle="tab" href="#s_tab1" id="sharing_services_for_me">Services being shared with you</a></li>
              <li ><a data-toggle="tab" href="#s_tab2" id="my_sharing_services">Services you are sharing</a></li>
              <li><a data-toggle="tab" href="#s_tab3" id="clickckckc">Service providers</a></li>
              <li><a data-toggle="tab" href="#s_tab4">Tools</a></li>
            </ul>
        </div>
      </div>
      <div class="col-xs-12 col-sm-9">
        <div class="tab-content">
          <div id="s_tab1" class="tab-pane fade in active">
            <div class="serv_table">
              <div class="view-bar">
                  <div class="row">
                    <div class="col-sm-3">
                      <select class="form-control">
                        <option>view-bar</option>
                      </select>
                    </div>
                    <div class="col-sm-9">
                      <input class="table-filter form-control" type="text" id="search-service-invited" placeholder="Filter shared items..." name="">
                    </div>
                  </div> 
              </div>
            <div class="table-responsive">
              <table class="table table-hover" id="shared-for-me-list">
                <tr>
                  <th>Service Name</th>
                  <th>Status</th>
                  <th>Service Provider</th>
                  <th>Point of Contact</th>
                  <th>POC Email Address</th>
                  <th>&nbsp;</th>
                </tr>
              </table>  
            </div>
          </div>
          </div>
          <div id="s_tab2" class="tab-pane fade ">
            <div class="tab-content">
              <div class="view-bar">
                  <div class="row">
                    <div class="col-sm-3">
                      <select class="form-control">
                        <option>view-bar</option>
                      </select>
                    </div>
                    <div class="col-sm-9">
                      <input class="table-filter form-control" type="text" id="search-service-owner" placeholder="Filter shared items..." name="">
                    </div>
                  </div> 
              </div>
              <div class="table-responsive serv_table">
                <table class="table table-striped" id="shared-services-list">
                  <tbody>
                    <tr>
                      <th>Service Name</th>
                      <th>Status</th>
                      <th>Created Date</th>
                      <th style="text-align:center;">&nbsp;</th>
                    </tr>
                  </tbody>
                </table>  
              </div>
            </div>

          </div>
          <div id="s_tab3" class="tab-pane fade">
            <div class="table-responsive serv_table">
              <table class="table table-striped">
                <tr>
                  <th>Service Name</th>
                    <th>Status</th>
                    <th>Service Provider</th>
                    <th>Point of Contact</th>
                    <th>POC Email Address</th>
                  </tr>
              </table>
            </div>
          </div>
          <div id="s_tab4" class="tab-pane fade">
          <h3>Menu 3</h3>
          <p>Some content in menu 3.</p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog mymodel-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title button-title">Create Service</h4>
      </div>
      <div class="modal-body">
        
            <div class="form-group">
                <label for="service_title">Service Name</label>
                <input type="text" class="form-control" id="service_title" name="service_title" placeholder="Enter Service Title"/>
            </div>  
            
            <div class="form-group">
                <label for="validation_date">Service Validation Date</label>
                <input type='text' id='datetimepicker2' name="validation_date" id="validation_date" class="form-control date" />
            </div>
            <div class="form-group">
                <label for="regulations_standard">Service Description</label>
                <textarea class="form-control" rows="3" name="regulations_standard" id="regulations_standard" style="resize:none;" placeholder="Enter service description"></textarea>
            </div>
              <div class="form-group">
                <label for="description">Applicable regulations and standards</label>
                <textarea class="form-control" rows="3" name="service_description" id="service_description" style="resize:none;" placeholder="Enter applicable regulations and standards"></textarea>
            </div>
             <div class="form-group">
                <label for="description">Data Classification</label>
                <select class="form-control" name="service_data_classification" id="service_data_classification" style="width: 30%;">
                  <option value="" selected>---Please Select---</option>
                  <option value="public">Public</option>
                  <option value="confidential">Confidential</option>
                  <option value="restricted">Restricted</option>
                  <option value="highlyrestricted">Highly Restricted</option>
                </select>
            </div>  
             <div class="form-group">
                <label for="description">Business controls</label>
                <textarea class="form-control" rows="3" name="business_controls" id="business_controls" style="resize:none;" placeholder="Enter business controls"></textarea>
            </div> 
            <div class="form-group">
                <label for="description">Data security controls</label>
                <textarea class="form-control" rows="3" name="security_controls" id="security_controls" style="resize:none;" placeholder="Enter data security controls"></textarea>
            </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-next" id="next_myModal1">Submit</button><!-- id="next_myModal1" -->
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="service-company" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog mymodel-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title button-title">Company Informatiion</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="phone">Company Name</label>
          <input type="text" class="form-control" placeholder="Enter company name" id="company_name" name="company_name" >
        </div>
        <div class="form-group">
          <label for="phone">Company Website</label>
          <input type="text" class="form-control" placeholder="Enter company website" id="company_website" name="company_website" >
        </div>
        <div class="form-group">
          <label for="phone">Company Address</label>
          <input type="text" class="form-control" placeholder="Enter company address" id="company_address" name="company_address" >
        </div>
        <div class="form-group">
          <label for="phone">Company City</label>
          <input type="text" class="form-control" placeholder="Enter company city" id="company_city" name="company_city">
        </div>
        <div class="form-group">
          <label for="phone">Company State</label>
          <input type="text" class="form-control" placeholder="Enter company state" id="company_state" name="company_state">
        </div>
        <div class="form-group">
          <label for="phone">Company ZIP</label>
          <input type="text" class="form-control" placeholder="Enter zipcode" id="company_zip" name="company_zip" >
        </div>
        <div class="form-group">
          <label for="Fileinput">Upload Company Logo</label>
            <form id="Ajaxform">
                <input type="file" name="ajax_file" id="Fileinput">
            </form>
        </div>
        <div class="form-group">
            <div class="img_preview">
              <div class="im_progress"></div>
                <img src="" id="img_preview">
            </div>
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-next" id="next_CompanyInfo">Next</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="service-company-contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog mymodel-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title button-title">Company Contact Informatiion</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="phone">Name</label>
          <input type="text" class="form-control" placeholder="Enter contact name" id="contact_name" name="contact_name" >
        </div>
        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="text" class="form-control" placeholder="Enter contact phone number" id="contact_phone_number" name="contact_phone_number" >
        </div>
        <div class="form-group">
          <label for="phone">Phone Ext.</label>
          <input type="text" class="form-control" placeholder="Enter phone ext." id="contact_phone_ext" name="contact_phone_ext" >
        </div>
        <div class="form-group">
          <label for="phone">Contact Email</label>
          <input type="email" class="form-control cust-email" placeholder="Enter contact email" id="contact_email" name="contact_email" >
        </div>
        <div class="form-group">
          <label for="phone">Alt Contact (Name &#38; Email)</label>
          <input type="text" class="form-control" placeholder="Enter alt contact (Name &#38; Email)" id="contact_alt" name="contact_alt" >
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-prev" id="Prev_CompanyContact">Prev</button>
          <button type="button" class="btn btn-default btn-next" id="next_CompanyContact">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog mymodel-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title button-title">Upload Service Documents</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="phone">Add new service document</label>
        {!! Form::open([ 'route' => [ 'document.store' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
            {{ csrf_field() }}
        {!! Form::close() !!}
        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-prev" id="Prev_myModal2">Prev</button>
        <button type="button" class="btn btn-default btn-next" id="next_myModal2">Next</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog mymodel-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title button-title" >Add Service Comments</h4>
      </div>
      <div class="modal-body">
         <form role="form" method="POST" action="#">
            <div class="form-group">
                <label for="comments">Leave comment</label>
                <textarea class="form-control" rows="5" name="comment" id="comment" style="resize:none;" placeholder="Leave service comment"></textarea>
            </div> 
            <div class="form-group">
                <div class="checkbox">
                    <label>
                    <input type="checkbox" name="agree" class="agree" value="agree" /> <strong>Agree with the terms and conditions?</strong>
                    </label>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-prev" id="Prev_myModal4">Prev</button>
        <button type="button" class="btn btn-default btn-next" id="submit_service">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>-->
<div id="dialog" title="Terms and Conditions" style="display: none;">
                    <p>Lorem ipsum dolor sit amet, veniam numquam has te. No suas nonumes recusabo mea, est ut graeci definitiones. His ne melius vituperata scriptorem, cum paulo copiosae conclusionemque at. Facer inermis ius in, ad brute nominati referrentur vis. Dicat erant sit ex. Phaedrum imperdiet scribentur vix no, ad latine similique forensibus vel.</p>
                    <p>Dolore populo vivendum vis eu, mei quaestio liberavisse ex. Electram necessitatibus ut vel, quo at probatus oportere, molestie conclusionemque pri cu. Brute augue tincidunt vim id, ne munere fierent rationibus mei. Ut pro volutpat praesent qualisque, an iisque scripta intellegebat eam.</p>
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
 
  
  $('#datetimepicker2').datepicker({
       autoclose: true,
       todayHighlight: true,
       dateFormat: 'mm/dd/yy',
       minDate:new Date()
   });


  $('company_profile_contact_info').hide();
  var checkFilesAction = true;
  $("#loadingDiv").show();
  $('#user_invite').prop("disabled", true);
         function initDropzonesHas() {
              $('.dropzone').each(function () {
                  checkFilesAction = false;
                  let dropzoneControl = $(this)[0].dropzone;
                   if (dropzoneControl) {

                      dropzoneControl.cleaningUp = true;
                      dropzoneControl.removeAllFiles();
                      dropzoneControl.cleaningUp = false;
                  }
                  //if (dropzoneControl) {
                   //   dropzoneControl.destroy();
                  //}
              });
          }
          
          // Check user profile is registered with company profile or not

          $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url("/company-profile/user") }}',
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                //data: formData,
                datatype: 'json',

                beforeSend: function() {
                    // do some loading options
                },
                success: function(data) {
                  var getResult = data.data;
                  var varSearch = false;
                  $("#loadingDiv").hide();

                   if(getResult.return_status === false){
                      $('#company_profile_contact_info').hide();
                   }
                   else{
                    $('#company_profile_contact_info').show();
                   }
 
                    if(getResult.company_logo){
                        $("#company_profile_logo").attr("src","companylogo/"+getResult.company_logo);
                    }

                    $('body').find('#dash_company_name').text(getResult.company_name);
                    $('body').find('#dash_company_website_name').text(getResult.company_website);
                    $('body').find('#dash_company_address').text(getResult.company_address);
                    $('body').find('#dash_company_city').text(getResult.company_city);
                    $('body').find('#dash_company_state').text(getResult.company_state);
                    $('body').find('#dash_company_zip').text(getResult.company_zip);
                    $('body').find('#dash_cc_name').text(getResult.contact_name);
                    $('body').find('#dash_cc_phone').text(getResult.contact_phone_number);
                    $('body').find('#dash_cc_ext').text(getResult.contact_phone_ext);
                    $('body').find('#dash_cc_name_email').text(getResult.contact_alt);
                    $('body').find('#dash_cc_email_address').text(getResult.contact_email);

                    getServiceForUsers(getResult, varSearch);

                    $("#my_sharing_services").trigger("click");
                },
                complete: function() {
                    // success alerts
                },
                error: function(xhr, status, error) {
                  $("#loadingDiv").hide();
                  console.log('something error to load with prifile information');
                }
            });

       // $('#Prev_myModal1').attr('disabled',true);
        
        $('body').on('click', '#createService', function(e) {
            e.preventDefault();
            $('#company_name').val('');
            $('#company_website').val('');
            $('#company_address').val('');
            $('#company_city').val('');
            $('#company_state').val('');
            $('#company_zip').val('');
                        
            $('#Fileinput').val('');
              initDropzonesHas();
            $('#img_preview').attr('src', '');
            $('.img_preview').hide();
            $("#loadingDiv").show();
             $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url("/company-profile/user") }}',
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                //data: formData,
                datatype: 'json',
                beforeSend: function() {
                    // do some loading options
                },
                success: function(data) {
                  var getResponse = data.data.return_status;

                  $("#loadingDiv").hide();

                  if(getResponse === false){
                    swal({
                          title: "Company Profile Information?",
                          text: "Please fill your company profile information before creating your services!",
                          icon: "info",
                          buttons: true,
                          dangerMode: false,
                          closeOnClickOutside: false,
                          closeOnEsc: false,
                        })
                    .then((willDelete) => {
                        if (willDelete) {
                          $('#service-company').modal({
                            backdrop: 'static',
                            fadeDuration: 1000,
                            fadeDelay: 0.50
                          });
                        }
                    });
                  }
                  else {
                     $('#myModal1').modal({
                        backdrop: 'static',
                        fadeDuration: 1000,
                        fadeDelay: 0.50
                      });  
                  }
                },
                complete: function() {
                    // success alerts
                },
                error: function(xhr, status, error) {
                  $("#loadingDiv").hide();
                  swal("Error!", "Something went wrong. Please try again,", "error");
                }
            });
        });


        /* For display the company logo preview */
        function DisplayImagePreview(input){
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function ajaxFormSubmit(form, callback) {
            var formData = new FormData($(form)[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url("/company-logo/upload") }}',
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

                    callback(data.success);
                },
         
                complete: function() {
                    // success alerts
                },
         
                error: function(xhr, status, error) {
                     swal("Error!", "Something went wrong. Please try again,", "error");
                }
            });
        }


        /*
            Function for checking for the valid email.
        */
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
            Function for checking for the valid url.
        */
        function checkUrl(url)
        {
            //regular expression for URL
            var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
         
            if(pattern.test(url)){
                return true;
            } else {
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

    /* Functionality for Email for user reagrding service information
        Functionality Start
    */
    var max_fields = 10; //maximum input boxes allowed
    var wrapper    = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed 
            x++; //text box increment
            $(wrapper).append('<div class="input_fields_wrap"><div><div class="form-group col-sm-6"><div><input type="email" class="form-control" placeholder="Enter email" id="useremail_'+x+'" name="useremail[]" required></div></div><div class="form-group col-sm-6"><label class="radio-inline"><input type="radio" name="access_'+x+'" value="read" >Readonly</label><label class="radio-inline"><input type="radio" name="access_'+x+'" value="both" checked>Read/Write</label><span class="remove_field" title="Remove"><i class="fa fa-close" ></i></span></div><div class="clearfix"></div></div></div>');
        }
        else{
          swal({
            title: "Warning!",
            text: "No more users allowed to invite on your service!",
            icon: "warning",
            buttons: false,
            dangerMode: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
            timer: 2000,
          })

        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); 
        $(this).closest('.input_fields_wrap').remove();
        //$(this).parent('div').parent('div').remove(); 
        x--;
    })
    // End functionality


    /* Functionality for uploading documents and save the fields value 
        Functionality start
    */
    var varGlobals = {}; 
    var documents = [];
    var varGlobalsCompany = {}; 
        // Upload company logo functionality 
        // Check the file validation with there allowed extension for image
        $('body').on('change','#Fileinput',function(){
            var filename = $(this).val();
            var extension = filename.replace(/^.*\./, '');
            if (extension == filename) {
                extension = '';
            } else {
                extension = extension.toLowerCase();
            }

            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
            if ($.inArray(extension, fileExtension) == -1) {
                $(this).val('');
                swal("Error!", "Only formats are allowed :"+fileExtension.join(', '), "error");
                return false;
            }

            var imgpreview = DisplayImagePreview(this);
            $(".img_preview").show();
            
            ajaxFormSubmit('#Ajaxform',function(output){
                varGlobalsCompany.company_logo = output;
            }); 
        });


      $('body').on('click', '#Prev_CompanyInfo', function(e) {
        $('#service-company').modal('hide');
        $('#myModal1').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });
      });


      $('body').on('click', '#next_CompanyInfo', function(e) {
        var varUrl  = $('#company_website').val();
        var varCompanyName = $('#company_name').val();
        var varCompanyAddress = $('#company_address').val();
        var varCompanyCity = $('#company_city').val();
        var varCompanyState = $('#company_state').val();
        var varCompanyZip = $('#company_zip').val();

        
        if(varUrl !== null && varUrl !== '') {
          if(!checkUrl(varUrl)){
            swal({ 
              title: "Error!", 
              text: "Please enter valid website address.", 
              icon: "error",
              closeOnClickOutside: false 
            }).then((value) => {
              $('#company_website').focus();
            });
              return false;
            }
        }
        
        if(varCompanyName == '' || varCompanyName == 'undefined'){
            $('#company_name').focus();
            return false;
        }
        
        if(varCompanyAddress == '' || varCompanyAddress == 'undefined'){
            $('#company_address').focus();
            return false;
        }

        if(varCompanyCity == '' || varCompanyCity == 'undefined'){
            $('#company_city').focus();
            return false;
        }

        if(varCompanyState == '' || varCompanyState == 'undefined'){
            $('#company_state').focus();
            return false;
        }

        if(varCompanyZip == '' || varCompanyZip == 'undefined'){
            $('#company_zip').focus();
            return false;
        }

        varGlobalsCompany.company_website = varUrl;
        varGlobalsCompany.company_name = varCompanyName;
        varGlobalsCompany.company_address = varCompanyAddress;
        varGlobalsCompany.company_city = varCompanyCity;
        varGlobalsCompany.company_state = $('#company_state').val();
        varGlobalsCompany.company_zip = $('#company_zip').val();    
                
        $('#service-company').modal('hide');
        $('#service-company-contact').modal({
            backdrop: 'static',
            fadeDuration: 1000,
            fadeDelay: 0.50
        });

      });

      $('body').on('click', '#Prev_CompanyContact', function(e) {
          $('#service-company-contact').modal('hide');
          $('#service-company').modal({
              backdrop: 'static',
              fadeDuration: 1000,
              fadeDelay: 0.50
          });
      });

      $('body').on('click', '#next_CompanyContact', function(e) {
          var varContactEmail = $('#contact_email').val();
          var varContactPhoneNumber = $('#contact_phone_number').val();
          var varContactPhoneExt = $('#contact_phone_ext').val();
          var varContactName = $('#contact_name').val();
          var varContactAlt = $('#contact_alt').val();
         
          if(varContactEmail !== null && varContactEmail !== '') {
             if(!validateEmail(varContactEmail)){ 
                swal({ 
                  title: "Error!", 
                  text: "Please enter valid email address.", 
                  icon: "error",
                  closeOnClickOutside: false, 
                }).then((value) => {
                  $('#contact_email').focus();
                });
                return false;
              }
          }

          varGlobalsCompany.contact_name = varContactName;
          varGlobalsCompany.contact_phone_number = varContactPhoneNumber;
          varGlobalsCompany.contact_phone_ext = varContactPhoneExt;
          varGlobalsCompany.contact_email = varContactEmail;
          varGlobalsCompany.contact_alt = varContactAlt;
          

          $("#loadingDiv").show();
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'POST',
              url: '{{ route("user.company-information") }}',
              data: varGlobalsCompany,
              success: function (data){
                  var responseResult = data.data;
                  $('#service-company-contact').modal('hide');
                  $("#loadingDiv").hide();   
                  $('#company_profile_contact_info').show();               
                  swal({ 
                    title: "Success!", 
                    text: "Company information has been saved successfully. Now you are able to add your service.", 
                    icon: "success",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                  }).then((value) => {                   
                    $('body').find('#dash_company_name').text(responseResult.company_name);
                    $('body').find('#dash_company_website_name').text(responseResult.company_website);
                    $('body').find('#dash_company_address').text(responseResult.company_address);
                    $('body').find('#dash_company_city').text(responseResult.company_city);
                    $('body').find('#dash_company_state').text(responseResult.company_state);
                    $('body').find('#dash_company_zip').text(responseResult.company_zip);
                    $('body').find('#dash_cc_name').text(responseResult.contact_name);
                    $('body').find('#dash_cc_phone').text(responseResult.contact_phone_number);
                    $('body').find('#dash_cc_ext').text(responseResult.contact_phone_ext);
                    $('body').find('#dash_cc_email_address').text(responseResult.contact_alt);
                    $('body').find('#dash_cc_name_email').text(responseResult.contact_email);
                  }); 
              },
              error: function(jqXhr) { 
                  $("#loadingDiv").hide();
                  var errors = jqXhr.responseJSON; //this will get the errors response data.
                if(errors.length > 0){
                  errorsHtml = '';
                  $.each( errors , function( key, value ) {
                    $.each( value , function( k, v ) {
                      errorsHtml += v[0]+'!<br>';
                    });          
                  });
                }
                else{
                  errorsHtml = errors.errors;
                }

                var elem = document.createElement("div");
                elem.innerHTML = errorsHtml;

                swal({
                  title: "Error!",
                  content: elem,
                  icon: "error"
                });
              }
            });
      });

        $('body').on('click', '#Prev_myModal2', function(e) {
            e.preventDefault();
            $('#myModal2').modal('hide');
            
            $('#myModal1').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });
        });

        $('body').on('click', '#next_myModal2', function(e) {
            e.preventDefault();
            $('#myModal2').modal('hide');
            $('#userInviteModel').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });

        });

        $('body').on('click', '#Prev_myModal3', function(e) {
            e.preventDefault();
            $('#userInviteModel').modal('hide');
            $('#myModal2').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });
        });
       
        $('#myModal2').on('shown.bs.modal', function (e) {        
          var cnt = 0;
          //Simple Dropzonejs 
          $("#image-upload").dropzone({
            maxFilesize: 32,
            maxFiles: 10,
            timeout: 10000,
            addRemoveLinks: true,
            //uploadMultiple: true,
            autoProcessQueue: true,
            parallelUploads: 1,
            acceptedFiles: ".txt,.csv,.pdf,.xls,.xlsx,.doc,.docx,.ppt,.odt,.rtf,.xlr",
            dictFileTooBig: 'File is larger than 16MB',
            dictDefaultMessage: "Drop or Upload (add) new document here!",
              renameFile: function(file) {
                  var today = new Date();
                  var time = today.getTime();
                  var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                  var     docname = file.name.replace(/ /g,"_");
                  return time+'_'+date+'_'+docname;
              },
              success: function(file, response) {
                  var imgName = response.success;
                  file.previewElement.classList.add("dz-success");
                  documents.push(imgName);
                  varGlobals['docs'] = documents;
              },
              removedfile: function(file) {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url("/document/delete") }}',
                    data: {filename: name},
                    success: function (data){
                        var index = documents.indexOf(data);
                        if (index > -1) {
                          documents.splice(index, 1);
                        }
                        varGlobals['docs'] = documents;
                        if(checkFilesAction){

                          swal({ title: "Success!", text: "File has been successfully removed!!", icon: "info", buttons: false, dangerMode: true, closeOnClickOutside: false, closeOnEsc: false, timer: 2000});
                        }
                    },
                    error: function(e) {
                         swal("Error!", "File not removed.", "error");
                    }});
                    
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
              },
              error: function(file, response) {
                  file.previewElement.classList.add("dz-error");
                  swal("Error!", "File not upload there are some errors.", "error");
              }
            });
        });

        // End functionality for document upload


        $('body').on('click', '#next_myModal1', function(e) {
            e.preventDefault();
            var varTitle = $('#service_title').val();
            var varDescription = $('#service_description').val();
            var varDataClassification = $('#service_data_classification').val();
            var varValidationDate = $('#datetimepicker2').val();
            var varRegulationsStandard = $('#regulations_standard').val();
            var varBusinessControls = $('#business_controls').val();
            var varSecurityControls = $('#security_controls').val();

           // var varCompanyName = $('#company_name').val();
            if(varTitle=='' || varTitle=='undefined'){
                $('#service_title').focus();
                return false;
            }

            if(varValidationDate=='' || varValidationDate=='undefined'){
                $('#datetimepicker2').focus();
                return false;
            }
            else{
              console.log(varValidationDate);
              var dateParts = varValidationDate.split("/");
              var varValidationDate = dateParts[2]+'-'+dateParts[0]+'-'+dateParts[1]; 
              console.log(varValidationDate);
                //date = new Date(dateParts[2], dateParts[1]-1, dateParts[0]);
            }

            if(varDescription == '' || varDescription == 'undefined'){
                $('#service_description').focus();
                return false;
            }

            if(varRegulationsStandard=='' || varRegulationsStandard=='undefined'){
                $('#regulations_standard').focus();
                return false;
            }
                       
            if(varDataClassification == '' || varDataClassification == 'undefined'){
                $('#service_data_classification').focus();
                return false;
            }

            if(varBusinessControls == '' || varBusinessControls == 'undefined'){
                $('#business_controls').focus();
                return false;
            }

            if(varSecurityControls == '' || varSecurityControls == 'undefined'){
                $('#security_controls').focus();
                return false;
            }

            varGlobals.service_title = varTitle;
            varGlobals.validation_date = varValidationDate;
            varGlobals.service_description = varDescription;
            varGlobals.regulations_standard = varRegulationsStandard;
            varGlobals.data_classification = varDataClassification;
            varGlobals.business_controls = varBusinessControls;
            varGlobals.security_controls = varSecurityControls;
            /*$('#myModal1').modal('hide');
            $('#myModal2').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });*/
            $(this).prop("disabled", true);
            $("#loadingDiv").show();
            $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("service.info") }}',
                data: varGlobals,
                success: function (data){
                    $('#myModal1').modal('hide');
                    $("#loadingDiv").hide();
                    $(this).prop("disabled", false);
                    $("#my_sharing_services").trigger("click");
                    swal({
                      title: "Success!",
                      text: "Your service has been saved successfully!",
                      icon: "success",
                      dangerMode: false,
                      closeOnClickOutside: false,
                      closeOnEsc: false
                    });                    
                },
                error: function(e) {
                  $("#loadingDiv").hide();
                  $(this).prop("disabled", false);
                  swal("Error!", "Something went wrong.", "error");
                }
            });
        });


        $('body').on('click', '#user_invite', function(e) { 
            e.preventDefault();
            var userDetails = [];
            var k = 0;
            var available = false;
            $('input[name^="useremail[]"]').each(function() {
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
            $(this).prop("disabled", true);
            $("#loadingDiv").show();
           
            $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("service.info") }}',
                data: varGlobals,
                success: function (data){
                    $('#userInviteModel').modal('hide');
                    $("#loadingDiv").hide();
                    $(this).prop("disabled", false);
                    $("#my_sharing_services").trigger("click");
                      swal({
                        title: "Success!",
                        text: "Your service has been saved successfully!",
                        icon: "success",
                        dangerMode: false,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                      });                    
                },
                error: function(e) {
                  $("#loadingDiv").hide();
                  $(this).prop("disabled", false);
                  swal("Error!", "Something went wrong.", "error");
                }
            });

            $('#submit_service').prop("disabled", true);
        });

        $('body').on('click', '#Prev_myModal4', function(e) {
            e.preventDefault();
            $('#myModal4').modal('hide');
            $('#userInviteModel').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });
        });

        $('body').on('change', 'input[name=agree]', function(){
            if($(this).is(":checked")) {
                 $( "#dialog" ).dialog({
                    resizable: false,
                    height: "auto",
                    width: 400,
                    //height: 200
                    modal: false,
                    title: 'Title',
                    dialogClass: 'ModalWindowDisplayMeOnTopPlease',
                    buttons: {
                        'I agree to the terms of Service': function() {
                            $(this).dialog('close');
                            $('#user_invite').prop("disabled", false);
                        }
                    }
                });
            }
            else{
                $('#user_invite').prop("disabled", true);   
            }
        });

      
        $('#myModal1').on('shown.bs.modal', function (e) {
            // $('#myModal2').modal('hide');
        });

        $('#AddUserForm').on('hidden.bs.modal', function (e) {});
        
        $('#AddUserForm').modal({
            backdrop: 'static',
            fadeDuration: 1000,
            fadeDelay: 0.50
        }); 



      $('body').on('click', '#sharing_services_for_me', function(e){
         e.preventDefault();
          $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url("/shared-services-to-user") }}',
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                //data: formData,
                datatype: 'json',
                beforeSend: function() {
                    // do some loading options
                },
                success: function(data) {
                 var getResult = data.data;
                 var search= false;
                  $("#loadingDiv").hide();
                  getServiceForUsers(getResult, search);
                },
                complete: function() {
                    // success alerts
                },
         
                error: function(xhr, status, error) {
                  $("#loadingDiv").hide();
                  console.log('something error to load with prifile information');
                }
            });
      });

      $('body').on('click', '#my_sharing_services', function(e){
         e.preventDefault();
          $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url("/get-services-from-user") }}',
                type: 'GET',
                cache: false,
                contentType: false,
                processData: false,
                //data: formData,
                datatype: 'json',

                beforeSend: function() {
                    // do some loading options
                },
                success: function(data) {
                 var getResult = data.data;

                  $("#loadingDiv").hide();
                  var search= false;
                  getServiceSubscriber(getResult, search);  

                  
                },
                complete: function() {
                    // success alerts
                },
         
                error: function(xhr, status, error) {
                  $("#loadingDiv").hide();
                  console.log('something error to load with prifile information');
                }
            });
      });

      $('body').on('click', '.create-new-service', function(e){
        $("#createService").trigger("click");   
      });

      $('body').on('click', '.delete-service', function(e){
        e.preventDefault();
        var serviceID = $(this).attr('data-val');
        var arrService = {};  
        arrService.service_request = serviceID; 
            swal({ 
              title: "Warning!",
              buttons: true, 
              text: "Are you want to delete your services.Once delete will not recover.", 
              icon: "warning",
              closeOnClickOutside: false,
              closeOnEsc: true,
              cancel: true,
              confirm: true,
            }).then((willDelete) => {
                if (willDelete) {
                  $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url("/delete-service-from-user") }}',
                    data: arrService,
                    success: function (data){   
                    
                      $("#my_sharing_services").trigger("click");
                        swal({ 
                          title: "Success!", 
                          text: "Your request has been completed successfully.", 
                          icon: "success",
                          closeOnClickOutside: false,
                          closeOnEsc: false,
                          timer: 3000,
                        });
                    },
                    error: function(jqXhr) { 
                      var errors = jqXhr.responseJSON; //this will get the errors response data.
                                        
                      errorsHtml = '';
                      $.each( errors , function( key, value ) {
                        console.log(value);
                        $.each( value , function( k, v ) {
                          console.log(v[0]);
                          errorsHtml += v[0]+'!<br>';
                        });          
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
            });
      });

      $
      ('body').on('click', '.leave-service', function(e){
        e.preventDefault();
        var serviceID = $(this).attr('data-val');
        var arrService = {}; 
        $("#loadingDiv").show();  
        arrService.service_request = serviceID; 
         swal({ 
                  title: "Warning!", 
                  buttons: true, 
                  text: "Are you sure to leave this service?", 
                  icon: "warning",
                  closeOnClickOutside: false,
                  closeOnEsc: false,
                  cancel: true,
                  confirm: true,
                }).then((willDelete) => {
                    if (willDelete) {
                      console.log("YYYYYYY");
                      $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("/leave-service-from-user") }}',
                        data: arrService,
                        success: function (data){ 
                          $("#loadingDiv").hide(); 
                          var getResult = data.data;
                          var search = false;
                            getServiceForUsers(getResult, search); 
                            swal({ 
                              title: "Success!", 
                              text: "Your request has been completed successfully.", 
                              icon: "success",
                              closeOnClickOutside: false,
                              closeOnEsc: false,
                            });
                        },
                        error: function(jqXhr) { 
                          $("#loadingDiv").hide();
                          var errors = jqXhr.responseJSON; //this will get the errors response data.
                                            
                          errorsHtml = '';
                          $.each( errors , function( key, value ) {
                            console.log(value);
                            $.each( value , function( k, v ) {
                              console.log(v[0]);
                              errorsHtml += v[0]+'!<br>';
                            });          
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
                    } else {
                      
                      $("#loadingDiv").hide();
                    }
                });
      }); 

  // Search service those are shared for users
  $('body').on('keyup', '#search-service-invited', function(e){
    var varQuery = $('#search-service-invited').val();
        $("#loadingDiv").show();
       
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: "{{ route('user.search-user-services-invited') }}",
        data:{query:varQuery},
        dataType:'json',
        success: function (data){ 
          $("#loadingDiv").hide();    
          var getResult = data.data;
          var search = true;
          getServiceForUsers(getResult, search);          
        },
        error: function(jqXhr) { 
         $("#loadingDiv").hide();   
         console.log('No result found.')
        }
      });
    
  });

  // Search service those are shared for users

  $('body').on('keyup', '#search-service-owner', function(){
    var varQuery = $('#search-service-owner').val();
    
      $("#loadingDiv").show(); 
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: "{{ route('user.search-services-subscriber') }}",
        data:{query:varQuery},
        dataType:'json',
        success: function (data){ 
          $("#loadingDiv").hide();    
          var getResult = data.data;
          var search = true;
          getServiceSubscriber(getResult, search);          
        },
        error: function(jqXhr) { 
         $("#loadingDiv").hide();   
         console.log('No result found.')
        }
      });
    
  });
    

  function getServiceSubscriber(getResult, search){
    console.log(getResult);
    var trSharedServices = '<tr><th>Service Name</th><th class="th-text-center">Status</th><th class="th-text-center">Created Date</th><th class="th-text-center">Action</th></tr>';
      if(getResult.shared_services.length  > 0){
        $.each(getResult.shared_services, function (i, item) {
          trSharedServices += '<tr><td><a href="/service-detail/'+ item.route+'/detail">' + item.service_title + '</a></td><td align="center"><div class="'+item.service_status+'"></div></td>ss<td></td><td class="action"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="javascript:void(0)" data-val="' + item.id + '" title="Delete Service" class="delete-service"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp&nbsp;<strong class="count">'+item.total_users+'</strong>&nbsp;<i class="fa fa-users" aria-hidden="true"></i></td></tr>';
        });
         $("#shared-services-list tbody").html(trSharedServices);
      }
      else{
        if(search)
          $("#shared-services-list tbody").html('<tr><td colspan="4" align="center">No search matching result found!</td></tr>');
        else 
          $("#shared-services-list tbody").html('<tr><td colspan="4" align="center">Welcome! No service is availalbe. Are you want to add new service? <button class="btn create-new-service" >Create Service</button> </td></tr>'); 
      }
  }

  function getServiceForUsers(getResult, search){
    var trSharedServicesForMe = '<tr><th>Service Name</th><th>Status</th><th>Service Provider</th><th>Point of Contact</th><th>POC Email Address</th><th>&nbsp;</th></tr>';

      if(getResult.shared_services_forme.length  > 0){
        $.each(getResult.shared_services_forme, function (i, item) {
          trSharedServicesForMe += '<tr><td align="left">' + item.service_title + '</td><td><div class="'+item.service_status+'"></div></td><td align="left">' + item.service_provider + '</td><td align="left">' + item.poc + '</td><td align="left">' + item.poc_email + '</td><td class="action"><a href="javascript:void(0)" title="Leave service" data-val="' + item.service_id + '" class="leave-service"><i class="fa fa-sign-out" aria-hidden="true"></i></a></td></tr>';
        });

        $("#shared-for-me-list tbody").html(trSharedServicesForMe);
      }
      else{
        if(search){
          $("#shared-for-me-list tbody").html('<tr><td colspan="6" align="center">No search matching result found!</td></tr>');
        }
        else {
         $("#shared-for-me-list tbody").html('<tr><th>Service Name</th><th>Status</th><th>Service Provider</th><th>Point of Contact</th><th>POC Email Address</th><th>&nbsp;</th></tr><tr><td colspan="6" align="center">No more services shared with you.</td></tr>');
        }  
      }
  }

}); 
</script>
@endsection
