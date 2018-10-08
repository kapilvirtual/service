<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('partials.landinghead')
</head>
<body>
<?php //@inject('request', 'Illuminate\Http\Request'); 

?>
@guest
<header class="top-nav-menu">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid navbar-container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="JavaScript:Void(0);" class="logo-btn">Logo</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav"> 
        <li><a href="JavaScript:Void(0);">Our Customers </a></li>        
        <li><a href="JavaScript:Void(0);">Pricing</a>
          <ul class="sub-menu">
            <li><a href="#">AA </a></li>
            <li><a href="#">BB </a></li>
            <li><a href="#">CC </a></li>
          </ul>
        </li>	     
          <li><a href="{{ route('user.signup')}}">Sign Up</a></li>
      </ul>      
        
      </ul>
    </div><!-- /.navbar-collapse -->
	<ul class="nav navbar-nav navbar-right login-btn">
        <li><a href="{{ route('user.login')}}"><img src="{{ asset('images/user-icon.png') }}" />Login</a></li> 
      </ul>
  </div><!-- /.container-fluid -->
</nav>
</header>
@else
<header class="top-nav-menu inner">
    <div class="topBar">
      <div class="container-fluid">
        <ul class="navigation pull-left">
          <li>
            <a href="{{URL::to('/')}}">Home</a>
          </li>
          <?php 
            $varCountService = App\Model\Service::where('user_id', Auth::id())->where('check_status','1');
            if($varCountService->count() > 0){
             $arrGetService = $varCountService->get();
          ?>
          <li class="dropdown">
            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">Service </a>
            <ul class="dropdown-menu">
              <?php foreach($arrGetService AS $k=>$v) {?>
                <li><a href="#">{{$v->service_title}}</a></li>
              <?php } ?>
            </ul>
          </li>
         <?php 
            }
          ?>
          <li class="favorites dropdown">
            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">Favorite </a>
            <ul class="dropdown-menu">
              <li><a href="#">Favorite 1.</a></li>
              <li><a href="#">Favorite 2.</a></li>
            </ul>
          </li>
          
        </ul>
        <ul class="navigation pull-right">
          <li class="profile dropdown">
            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">
              <div class="profile_photo">
                <img width="20" height="20" src="{{asset('images/user_demo.png')}}" class="unlinked_photo" alt="Profile Photo">
              </div>
              <span class="userName">{{{ isset(Auth::user()->name) ? Auth::user()->name.' '.Auth::user()->email : Auth::user()->email }}}</span>
            </a>          
            <ul class="dropdown-menu">
              <li><a href="#">Information</a></li>
              <li><a href="#">Profile Photo</a></li>
              <li><a href="#">Password</a></li>
              <li><a href="#">Email Addresses</a></li>
              <li><a href="#">Notifications</a></li>
              <li><a href="#">Security</a></li>
            </ul>
          </li>
          <li>
            <a href="#" target="_blank">Support</a>
          </li>
          <li class="sign_out">
            <a href="{{ route('user.logout')}}" data-method="delete" rel="nofollow">Sign Out</a>
          </li>
        </ul>
      </div>
    </div>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container navbar-container">
      
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a href="#" class="logo-btn">Logo</a>
      </div>
      
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav"> 
        <li><a href="{{URL::to('/')}}">Home</a></li>        
        <li><a href="#">Activity</a></li>   
        <li><a href="#">Users</a></li>        
        <li><a href="#">Settings</a></li>        
        <li><a href="#">Account</a></li>  
          <li><a href="#" class="btn create-service" id="createService">Create Service</a></li>         
        </ul> 
      </div>        
      </div>
    </nav>
  </header>
 
<!-- Notification section -->
    <section class="notify-section">
      <div class="container">
        <!--
        <div class="alert alert-success alert-dismissible fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <i class="fa fa-info-circle" aria-hidden="true"></i><strong>Success!</strong> This alert box could indicate a successful or positive action.
          <div class="clear"></div>
          <button class="btn">Add Your Credit Card</button>
        </div>
        !-->
        <div class="alert alert-info alert-dismissible fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <i class="fa fa-info-circle" aria-hidden="true"></i><strong>Info!</strong> This alert box could indicate a neutral informative change or action.
          <div class="clear"></div>
          <button class="btn">Add Your Credit Card</button>
        </div>
        <!--<div class="alert alert-warning alert-dismissible fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <i class="fa fa-info-circle" aria-hidden="true"></i><strong>Warning!</strong> This alert box could indicate a warning that might need attention.
          <div class="clear"></div>
          <button class="btn">Add Your Credit Card</button>
        </div>
        <div class="alert alert-danger alert-dismissible fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <i class="fa fa-info-circle" aria-hidden="true"></i><strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
          <div class="clear"></div>
          <button class="btn">Add Your Credit Card</button>
        </div>!-->
      </div>
    </section>
    @endguest
  <!-- /.Notification section --> 
 @yield('content')

@include('layouts.footer')
@include('partials.landingscripts')

</body>
</html>