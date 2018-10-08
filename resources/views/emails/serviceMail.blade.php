<!DOCTYPE html>
<html>
<head>
    <title>Service Information Email</title>
</head>
 
<body>
<h2>Welcome to the service:- {{$info['title']}}</h2>

<br/>
	<p> You have access on that service with  :- {{$info['accesstype']}} access.</p>
<br/>
<br/>
	Please register yourself on <a href="{{ url('/') }}/user-signup?uid={{$info['token']}}">User Signup</a>  with the given e-mail address "{{$info['emailaddress']}}" , Please fill your information and get your's provided services.
<br/>
<br/>
	<p> Your Service description are :- {{$info['description']}} </p>
<br/>

<a href="{{ url('/') }}">See your service detail </a>
</body>
 
</html>