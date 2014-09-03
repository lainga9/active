@section('title', 'Edit Activity ' . $activity->id)

@section('content')

	<h4>Edit {{ $activity->name }}</h4>

	@if( $activity->isCancelled() )
		<div class="alert alert-danger">
			This activity has been cancelled
		</div>
	@else
		{{ Form::open(
			['route' => [
				'activity.cancel', 
				$activity->id
			],
			'method' => 'PUT']
		) }}
			<button type="submit" class="btn btn-danger">Cancel Activity</button>
		{{ Form::close() }}
	@endif

	@if( $activity->isClosed() )
		<div class="alert alert-danger">
			This activity is closed for bookings
		</div>
	@else
		{{ Form::open(
			['route' => [
				'activity.close',
				$activity->id
			],
			'method' => 'PUT'
		]) }}
			<button type="submit" class="btn btn-info">Close Activity</button>
		{{ Form::close() }}
	@endif

	<hr />

	{{ Form::open(
		['route' => 
			[
				'activities.update',
				$activity->id
			],
			'method' => 'PUT',
			'files'	=> true
		]
	) }}

		@if( $activity->avatar )
			<img src="/active/public/{{ $activity->avatar }}" alt="" />
		@endif

		<div>Name</div>
		<p>
			{{ Form::text(
				'name',
				$activity->name
			) }}
		</p>

		<div>Description</div>
		<p>
			{{ Form::textarea(
				'description',
				$activity->description
			) }}
		</p>

		<div>Places Available</div>
		<p>
			{{ Form::text(
				'places',
				$activity->places
			) }}
		</p>

		<div>Street Address</div>
		<p>
			{{ Form::text(
				'street_address', 
				$activity->street_address
			) }}
		</p>

		<div>Town/City</div>
		<p>
			{{ Form::text(
				'town', 
				$activity->town
			) }}
		</p>

		<div>Postcode</div>
		<p>
			{{ Form::text(
				'postcode', 
				$activity->postcode
			) }}
		</p>

		<div>Date</div>
		<p>
			{{ Form::text(
				'date',
				$activity->date,
				['class' => 'datepicker']
			) }}
		</p>

		<div>Time From</div>
		<p>
			{{ Form::text(
				'time_from',
				$activity->time_from,
				['class' => 'timepicker']
			) }}
		</p>

		<div>Time Until</div>
		<p>
			{{ Form::text(
				'time_until',
				$activity->time_until,
				['class' => 'timepicker']
			) }}
		</p>

		<div>Cost</div>
		<p>
			{{ Form::text(
				'cost',
				$activity->cost
			) }}
		</p>

		<div>Display Pic</div>
		<p>
			{{ Form::file('avatar')}}
		</p>

		<hr />

		<h4>Class Type</h4>
		@include('_partials.forms.classTypes', compact('activity'))

		<hr />

		<h4>Class Level</h4>
		<p>
			{{ Form::select(
				'level_id',
				Base::toSelect(Level::all())
			) }}
		</p>

		<hr />

		{{ Form::submit(
			'Save Changes', 
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
				inline: true,
				scrollMonth: false,
				scrollInput: false
			});

			$('.timepicker').datetimepicker({
				datepicker: false,
				format: 'H:i',
				inline: true,
				step: 30,
				scrollTime: false,
				scrollInput: false
			});

		});

	</script>

@stop