@section('title', 'Add an Activity')

@section('content')

	<h4>Add an Activity</h4>

	{{ Form::open(
		['route' => 'activities.store', 'files' => true]
	) }}

		{{ Form::hidden('user_id', Auth::user()->id) }}

		<div>Name</div>
		<p>
			{{ Form::text(
				'name',
				Input::get('name', Input::old('name'))
			) }}
		</p>

		<div>Description</div>
		<p>
			{{ Form::textarea(
				'description',
				Input::get('description', Input::old('description'))
			) }}
		</p>

		<div>Places Available</div>
		<p>
			{{ Form::text(
				'places',
				Input::get('places', Input::old('places'))
			) }}
		</p>

		<div>Street Address</div>
		<p>
			{{ Form::text(
				'street_address', 
				Input::get('street_address', Input::old('street_address'))
			) }}
		</p>

		<div>Town/City</div>
		<p>
			{{ Form::text(
				'town', 
				Input::get('town', Input::old('town'))
			) }}
		</p>

		<div>Postcode</div>
		<p>
			{{ Form::text(
				'postcode', 
				Input::get('postcode', Input::old('postcode'))
			) }}
		</p>

		<div>Date</div>
		<p>
			{{ Form::text(
				'date',
				Input::get('date', Input::old('date')),
				['class' => 'datepicker']
			) }}
		</p>

		<div>Time From</div>
		<p>
			{{ Form::text(
				'time_from',
				Input::get('time_from', Input::old('time_from')),
				['class' => 'timepicker']
			) }}
		</p>

		<div>Time Until</div>
		<p>
			{{ Form::text(
				'time_until',
				Input::get('time_until', Input::old('time_until')),
				['class' => 'timepicker']
			) }}
		</p>

		<div>Cost</div>
		<p>
			{{ Form::text(
				'cost',
				Input::get('cost', Input::old('cost'))
			) }}
		</p>

		<div>Display Picture</div>
		<p>
			{{ Form::file('avatar') }}
		</p>

		<hr />

		<h4>Class Type</h4>
		@include('_partials.forms.classTypes', compact('classTypes'))

		<hr />

		<h4>Class Level</h4>
		<p>
			{{ Form::select(
				'level_id',
				Base::toSelect(Level::all()),
				Input::get('level_id', Input::old('level_id'))
			) }}
		</p>

		<hr />

		{{ Form::submit(
			'Add Activity', 
			['class' => 'btn btn-success']
		) }}

	{{ Form::close() }}
@stop

@section('scripts')

	<script>

		jQuery(document).ready(function($) {

			$('.datepicker').datetimepicker({
				timepicker: false,
				format:'Y-m-d',
				minDate: 0,
				inline: true
			});

			$('.timepicker').datetimepicker({
				datepicker: false,
				format: 'H:i',
				inline: true,
				step: 30
			});

		});

	</script>

@stop