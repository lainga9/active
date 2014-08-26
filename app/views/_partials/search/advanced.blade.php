<p>Find a class, instructor or venue in my area</p>

<div class="row">
	<div class="col-md-4">
		<div>Postcode/Area</div>
		<p>
			{{ Form::text(
				'location', 
				Input::get('location'),
				['placeholder' => 'eg: G1 HGH / Glasgow']
			) }}
		</p>	
	</div>
	<div class="col-md-4">
		<div>Search:</div>
		<p>
			{{ Form::text(
				'terms', 
				Input::get('terms'),
				['placeholder' => 'eg: Zumba']
			) }}
		</p>		
	</div>
	<div class="col-md-4">
		<div>Gender</div>
		<p>
			{{ Form::checkbox('genders[]', 'male') }} Male
			{{ Form::checkbox('genders[]', 'female') }} Female
		</p>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div>Type:</div>
		<p>
			{{ ClassType::printFormHTML() }}
		</p>		
	</div>
	<div class="col-md-4">
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
	</div>
	<div class="col-md-4">
		<div>Time:</div>
		<div class="row">
			<div class="col-md-3">
				From: <input type="text" class="datetimepicker" name="time_from" />	
			</div>
			<div class="col-md-3">
				Until: <input type="text" class="datetimepicker" name="time_until" />
			</div>
		</div>
	</div>
</div>

<div style="display: none;" class="refine">
	<div>Refine Search Radius (miles): <span class="distance-value"></span></div>
	<div class="distance-slider"></div>
</div>

{{ HTML::script('js/search.js') }}