<p>Find a class, instructor or venue in my area</p>

{{ Form::open(['route' => 'search']) }}

	<div>Postcode/Area</div>
	<p>
		{{ Form::text(
			'postcode', 
			Input::old('postcode'),
			['placeholder' => 'eg: G1 HGH / Glasgow']
		) }}
	</p>

	<div>Search:</div>
	<p>
		{{ Form::text(
			'terms', 
			Input::old('terms'),
			['placeholder' => 'eg: Zumba']
		) }}
	</p>

	<div>Type:</div>
	<p>
		{{ Form::select(
			'class_type_id',
			Base::toSelect(ClassType::all(), 'name', 'Select'),
			Input::old('class_type_id')
		) }}
	</p>

	<div>Day:</div>
	<p>
		@if(Base::$days)
			@foreach(Base::$days as $value => $name)
				<div>
					{{ Form::checkbox('day[]', $value) }} {{ $name }}
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
	</p>
	
	{{ Form::submit('Search', ['class' => 'btn btn-success']) }}

{{ Form::close() }}

<script id="search-results-template" type="text/x-handlebars-template">
	@include('_partials.client.json.activity-excerpt')
</script>