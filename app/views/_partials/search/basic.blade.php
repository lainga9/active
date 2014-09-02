<p>Find a class, instructor or venue in my area</p>

<h3>Organisations</h3>

{{ Form::open(['route' => 'organisations.search', 'method' => 'GET']) }}

	<div>Name</div>
	<p>{{ Form::text('name', Input::get('name')) }}</p>

	{{ Form::submit('Search', ['class' => 'btn btn-success']) }}
	
{{ Form::close() }}

<h3>People</h3>

{{ Form::open(['route' => 'users.search', 'method' => 'GET']) }}

	<div>Name</div>
	{{ Form::text('name', Input::get('name')) }}

	<div>Email</div>
	{{ Form::text('email', Input::get('email')) }}

	{{ Form::submit('Search', ['class' => 'btn btn-success']) }}

{{ Form::close() }}

<h3>Activities</h3>

{{ Form::open(['route' => 'activities.search', 'method' => 'GET']) }}

	<div>Postcode/Area</div>
	<p>
		{{ Form::text(
			'postcode', 
			Input::get('postcode'),
			['placeholder' => 'eg: G1 HGH / Glasgow']
		) }}
	</p>

	<div>Search:</div>
	<p>
		{{ Form::text(
			'terms', 
			Input::get('terms'),
			['placeholder' => 'eg: Zumba']
		) }}
	</p>

	<div>Type:</div>
	<p>@include('_partials.forms.classTypes', compact('classTypes'))</p>
	
	{{ Form::submit('Search', ['class' => 'btn btn-success']) }}

	<p><a href="{{ URL::route('search'); }}">Click here for Advanced Search</a></p>

{{ Form::close() }}

<script>
	
	jQuery(document).ready(function($) {

		var $classTypes = <?= json_encode($activities); ?>;

		$('input[name="terms"]').autocomplete({
			source: $classTypes
		});

	});

</script>