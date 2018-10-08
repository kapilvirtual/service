@extends('layouts.header')
@section('content')
<div id="loadingDiv"></div>
<!-- Banner section -->
<section class="container-fluid banner-view login_banner signup_page">
    <div class="row">
        <div class="banner-content">
            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8 sin_content">
                <h1>Analyze your <span>Entire service</span></h1>
                <h3>Lorem Ipsum has been the industry's standard dummy text ever since the1500s, <br>
when an unknown printer took a galley of type and scrambled.</h3>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 ">
                <div class="form_wrp sign_up">
                    <div class="form_strip">
                        <h1>Signup</h1>
                    </div>
                    <div class="feilds_wrp">
                    @if($warning && $warning!='')
                        <div class="alert alert-danger alert-dismissible ">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ $warning }}
                        </div>
                    @endif
                    @if($success && $success!='')
                        <div class="alert alert-success alert-dismissible ">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ $success }}{{ $email }}
                        </div>
                    @endif
                        <form class="form-horizontal" method="POST" action="">
                            <div class="form-group">
                                <input type="text" name="first_name" id="first_name" placeholder="First Name" autofocus />
                            </div>
                            <div class="form-group">
                                <input type="text" name="middle_name" id="middle_name" placeholder="Middle Name" autofocus/>
                            </div>
                            <div class="form-group">
                                <input type="text" name="last_name" id="last_name" placeholder="Last Name" autofocus />
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email"  value="{{ $email}}" placeholder="Email Address" autofocus />
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" placeholder="Enter Your Password" autofocus />
                            </div>
                            <div class="form-group">
                                <input type="password" name="password-confirm" id="password-confirm" placeholder="Confirm Your Password" />
                            </div>
                            <div class="form-group ">
                                <input type="submit" name="signup" id="signup" value="Submit" class="signup" />
                                <button type="reset">Cancel</button>
                            </div>
                            <div class="bottom_strip">
                                <img src="{{asset('/images/form_shadow.png')}}"  />
                            </div>
                        </form>
                        <input type="hidden" value="{{$defineid}}" name="defineid" id="defineid" />
                    </div>

                </div>
            </div>
        </div>
        <!-- arrow down --> 
    </div>
</section>

@stop
@section('javascript') 
<script>
$(document).ready(function(){
    
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //$('#dvLoading').hide();
    $("#loadingDiv").hide();

    function validatePassword(password){
        var regex = new RegExp("^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$");
        if (regex.test(password)) {
            return true;
        }
        
        return false;
    }

    function validateEmail(sEmail){
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;    
        
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    } 


        $('body').on('click', '.signup', function(e) {
            e.preventDefault();
            if($('#first_name').val() == ''){
                swal("Error!", "Please add first name", "error");
                $('#first_name').focus();
                return false;
            }
            else if($('#middle_name').val() == ''){
                $('#middle_name').focus();
                swal("Error!", "Please add midddle name", "error");
            }
            else if($('#last_name').val() == ''){
                $('#last_name').focus();
                swal("Error!", "Please add last name", "error");
            }
            else if(!validateEmail($('#email').val())){
                if($('#email').val() == ''){
                   swal("Error!", "Please enter email address.", "error");                    
                }
                else{
                   swal("Error!", "Please enter a valid email address.", "error");
                }
                return false;
            }
            else if(!validatePassword($('#password').val())){
                $('#password').focus();
                if($('#password').val() == ''){
                    swal("Error!", "Please enter your password.", "error");       
                }
                else{
                    swal("Error!", "Password must contain at least eight characters, At least one number and both lower and uppercase letters and special characters.", "error");   
                }
                return false;
            }
            else if($('#password-confirm').val() == ''){
                $('#password-confirm').focus();
                swal("Error!", "Please enter your confirm password.", "error");
                return false;
            }
            else if($('#password').val() != $('#password-confirm').val()){
                $('#password-confirm').focus();
                swal("Error!", "Your given password and confirm password are not match.", "error");   
                return false;
            }
            else{
                $(this).attr("disabled", "disabled");
                var name = $('#name').val();
                var first_name = $('#first_name').val();
                var middle_name = $('#middle_name').val();
                var last_name = $('#last_name').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var getIdentity = $('#defineid').val();


                    

                var formData = {
                    'name':  first_name,
                    'first_name':  first_name,
                    'middle_name':  middle_name,
                    'last_name':  last_name,
                    'email':  email,
                    'password':  password,
                    'user_status':  'inactive',
                    'identity' : getIdentity
                };

                //$('#dvLoading').show();
                $("#loadingDiv").show();
                $.ajax({
                    url: "{{ route('user.signup') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                       
                    $("#loadingDiv").hide();
                    $('#first_name').val('');
                    $('#middle_name').val('');
                    $('#last_name').val('');
                    $('#email').val('');
                    $('#password').val('');
                    $('#password-confirm').val('');
                    //$('#defineid').val('');
                    $(this).removeAttr('disabled');
                    swal({
                        title: "Success!",
                        text: "Your service has been saved successfully! Verify email has been sent to your email account. Please verify your account by clicking the link on your email account.",
                        icon: "success",
                        dangerMode: false,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        showCancelButton: false,
                        showConfirmButton: true
                      }); 
                    },
                    error: function (data){   
                        var json = JSON.parse(data.responseText);
                        $("#loadingDiv").hide();
                        $('#signup').prop("disabled", false);
                        var msg = '';
                        var index = 0;
                         $.each(json.errors, function (i, item) {
                            msg += i+' : '+item[index];
                            index++;
                         });
                            swal({
                                title: "Error!",
                                text: msg,
                                icon: "error",
                                dangerMode: false,
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                                buttons: {
                                    cancel: false,
                                    confirm: {
                                        text: "Ok",
                                        value: true,
                                        visible: true,
                                    },
                                }
                          });
                        //swal("Error",json.errors.name[0] , "error");
                    }

                });
            }
        });

$('.slider-activation').slick({
      slidesToShow: 1,
      slidesToScroll: 1
    });
});
if ($('#back-to-top').length) {
    var scrollTrigger = 150, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}
</script>
@endsection
