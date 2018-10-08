<!DOCTYPE html>
<html>
<head>
    <title>Service document upload inforamtion!</title>
</head>
 
<body>
<h2>Hi {{$user}}</h2>
<br/>
	<p> We want to inform you that the service "{{$service_title}}" subscriber have upload a new document {{$upload_document}}.</p>
<br/>


<a href="{{ url('/') }}">See service documentd.</a>
</body>
 
</html>