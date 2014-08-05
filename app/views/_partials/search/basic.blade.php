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

	<!-- <div>Day:</div>
	<p>
		@if(Base::$days)
			@foreach(Base::$days as $value => $name)
				<?php $old = Input::get('day') ? in_array($value, Input::get('day')) : null; ?>
				<div>
					{{ Form::checkbox(
						'day[]', 
						$value, 
						$old
					) }}

					{{ $name }}
				</div>
			@endforeach
		@endif
	</p>

	<div>Distance:</div>
	<p>
		{{ Form::text(
			'distance',
			Input::old('distance')
		) }}
	</p> -->
	
	{{ Form::submit('Search', ['class' => 'btn btn-success']) }}

	<p><a href="{{ URL::route('search'); }}">Click here for Advanced Search</a></p>

{{ Form::close() }}