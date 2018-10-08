@extends('layouts.header')

@section('content')
<section class="container-fluid banner-view login_banner">
    <div class="row">
        <div class="banner-content">
            <div class="form_wrp">
                <div class="form_strip">
                    <h1>Logo</h1>
                </div>

                 <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="feilds_wrp">
                        <h2>Forget Password</h2>
                        @if(Session::has('status'))
                            <div class="alert alert-success alert-dismissible ">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ Session::get('status') }}
                        </div>
                        @endif
                        <div class="form-group">
                            <input type="text" name="email" id="email" placeholder="E-Mail Address"  value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                      
                        <div class="form-group text-center">
                            <input type="submit" name="login" id="login" value="Send Password Reset Link" ><br>
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


@stop
@section('javascript') 

@endsection
