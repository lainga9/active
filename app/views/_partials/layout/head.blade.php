<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" />
	{{ HTML::style('css/jquery.datetimepicker.css') }}
	{{ HTML::style('css/style.css') }}
	{{ HTML::script('handlebars-v1.3.0.js') }}
	{{ HTML::script('js/jquery.datetimepicker.js') }}
	<style>
		body {
			padding: 20px;
		}
		
		img {
			max-width: 100%;
			display: block;
		}
	</style>

	@yield('head')

</head>
<body>