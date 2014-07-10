<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<style>
		img {
			max-width: 100%;
			display: block;
		}
	</style>
</head>
<body>

	<div class="container">
		@include('_partials.layout.header')
		@include('_partials.alerts')
		@include('_partials.errors')
		@yield('content')
	</div>

</body>
</html>