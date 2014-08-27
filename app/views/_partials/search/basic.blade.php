<p>Find a class, instructor or venue in my area</p>

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
	<p>
		{{ ClassType::printFormHTML() }}
	</p>
	
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