<p>Find a class, instructor or venue in my area</p>

<div>Postcode/Area</div>
<p>
	{{ Form::text(
		'location', 
		Input::old('location'),
		['placeholder' => 'eg: G1 HGH / Glasgow']
	) }}
</p>

<div style="display: none;" class="refine">
	<div>Refine Search Radius (miles):</div>
	<div class="distance-slider"></div>
	<!-- <p>
		{{ Form::text(
			'distance',
			5
		) }}
	</p> -->
</div>

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
	{{ ClassType::printFormHTML(ClassType::all()) }}
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

<script id="search-results-template" type="text/x-handlebars-template">
	@include('_partials.client.json.activity')
</script>