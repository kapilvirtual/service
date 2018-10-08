@extends('layouts.header')

@section('content')
<section class="container-fluid banner-view login_banner">
    <div class="row">
        <div class="banner-content">
            <div class="form_wrp">
                <div class="form_strip">
                    <h1>Logo</h1>
                </div>

                 <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="feilds_wrp">
                        <h2>Reset Password</h2>
                        @if(Session::has('status'))
                            <div class="alert alert-success alert-dismissible ">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ Session::get('status') }}
                        </div>
                        @endif
                        <div class="form-group">
                            <input type="text" name="email" id="email" placeholder="E-Mail Address"  value="{{ $email or old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" placeholder="Password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="password-confirm" placeholder="Confirm Password" required>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                            @endif
                        </div>
                      
                        <div class="form-group text-center">
                            <input type="submit"  value="Reset Password" ><br>
                        </div>
                        <div class="bottom_strip">
                            <img src="{{asset('/images/form_shadow.png')}}" >
                        </div>
                    </div>
                </form>
                
                
            </div>
        </div>
        <!-- arrow down --> 
    </div>
</section>





@endsection
