<p>Find a class, instructor or venue in my area</p>

<h3>Type of Search</h3>

<select class="search-select">
	<option data-type="activity" value="{{ URL::route('activities.search') }}">Activities</option>
	<option data-type="user" value="{{ URL::route('users.search') }}">Users</option>
	<option data-type="organisation" value="{{ URL::route('organisations.search') }}">Organisations</option>
</select>

<hr />

<div class="organisation-search" style="display: none;">
	<h3>Organisations</h3>
</div>

<div class="user-search" style="display: none;">
	<h3>Users</h3>

	<div class="row">
		<div class="col-md-4">
			<div>Name</div>
			<p>
				{{ Form::text(
					'name',
					Input::get('name'),
					['placeholder' => 'Name']
				) }}
			</p>	
		</div>
		<div class="col-md-4">
			<div>Email</div>
			<p>
				{{ Form::text(
					'email',
					Input::get('email'),
					['placeholder' => 'Email']
				) }}
			</p>
		</div>
		<div class="col-md-4">
			
		</div>
	</div>
</div>

<div class="activity-search" style="display: none;">
	<h3>Activities</h3>
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
				@include('_partials.forms.classTypes', compact('classTypes'))
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
</div>

{{ HTML::script('js/search.js') }}