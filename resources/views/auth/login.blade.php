@extends('layouts.header')
<?php /*@extends('layouts.app') 
*/ ?>
@section('content')
<section class="container-fluid banner-view login_banner">
    <div class="row">
        <div class="banner-content">
            <div class="form_wrp">
                <div class="form_strip">
                    <h1>Logo</h1>
                </div>

                 <form class="form-horizontal" method="POST" action="{{ route('user.login') }}">
                    {{ csrf_field() }}
                    <div class="feilds_wrp">
                        <h2>Login</h2>
                         @if(Session::has('status'))
                          <div class="form-group">
                            <div class="alert alert-info alert-dismissible ">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ Session::get('status') }}
                            </div> 
                        </div>
                         @endif
                         
                         @if(Session::has('warning'))
                          <div class="form-group">
                            <div class="alert alert-danger alert-dismissible ">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ Session::get('warning') }}
                            </div> 
                        </div>
                         @endif

                        @if(Session::has('flash_notice'))
                            <div class="alert alert-danger alert-dismissible ">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ Session::get('flash_notice') }}
                            </div>               
                        @endif
                        <div class="form-group">
                            <input type="text" name="email" id="email" placeholder="User Name"  value="{{ old('email') }}" >
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" placeholder="Password" >
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                         <div class="form-group">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> 
                            <label for="remember">Remember Me </label>
                        </div>
                        <div class="form-group text-center">
                                <input type="submit" name="login" id="login" value="Submit" ><br>
                            <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                        </div>
                        <div class="bottom_strip">
                            <img src="{{asset('../images/form_shadow.png')}}" >
                        </div>
                    </div>
                </form>
                
                
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

   /* $('body').on('click', '#login', function(e) {
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
            else{
                $(this).attr("disabled", "disabled");
                var email = $('#email').val();
                var password = $('#password').val();
                var remember = $('#remember');
                if ($('input#remember').prop('checked')) {
                    var formData = {
                        'email':  email,
                        'password': password,
                        'remember': 1               
                     };
                }
                else{
                    var formData = {
                        'email':  email,
                        'password': password
                     };   

                }
                
                 $.ajax({
                    url: "{{ route('user.login') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                        console.log(data);       
                        
                        $('#email').val();
                        $('#password').val();
                        if ($('input#remember').prop('checked')) {
                            $("#remember").prop('checked', true)

                        }
                       
                        $(this).removeAttr('disabled');
                         //window.location.href = "/home";

                    },
                    error: function (data){   console.log('YESSSerror');
                        var json = JSON.parse(data.responseText);
                        swal("Error",json.errors.name[0] , "error");
                        $(this).removeAttr('disabled');
                    }

                });
            }
    });/*

    
});
</script>
@endsection
