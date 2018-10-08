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
	<p> Your Service description are :- {{$info['description']}} </p>
<br/>

<a href="{{ url('/') }}">See your service detail.</a>
</body>
 
</html>