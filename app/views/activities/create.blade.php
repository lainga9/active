@section('title', 'Add an Activity')

@section('content')

	<h4>Add an Activity</h4>

	{{ Form::open(
		['route' => 'activities.store']
	) }}

		{{ Form::hidden('user_id', Auth::user()->id) }}

		<div>Name</div>
		<p>
			{{ Form::text(
				'name',
				Input::old('name')
			) }}
		</p>

		<div>Description</div>
		<p>
			{{ Form::textarea(
				'description',
				Input::old('description')
			) }}
		</p>

		<div>Places Available</div>
		<p>
			{{ Form::text(
				'places',
				Input::old('places')
			) }}
		</p>

		<div>Street Address</div>
		<p>
			{{ Form::text(
				'street_address', 
				Input::old('street_address')
			) }}
		</p>

		<div>Town/City</div>
		<p>
			{{ Form::text(
				'town', 
				Input::old('town')
			) }}
		</p>

		<div>Postcode</div>
		<p>
			{{ Form::text(
				'postcode', 
				Input::old('postcode')
			) }}
		</p>

		<div>Date</div>
		<p>
			{{ Form::text(
				'date',
				Input::old('date'),
				['class' => 'datepicker']
			) }}
		</p>

		<div>Time From</div>
		<p>
			{{ Form::text(
				'time_from',
				Input::old('time_from'),
				['class' => 'timepicker']
			) }}
		</p>

		<div>Time Until</div>
		<p>
			{{ Form::text(
				'time_until',
				Input::old('time_until'),
				['class' => 'timepicker']
			) }}
		</p>

		<div>Cost</div>
		<p>
			{{ Form::text(
				'cost',
				Input::old('cost')
			) }}
		</p>


		<h4>Class Type</h4>
		{{ ClassType::printFormHTML() }}

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