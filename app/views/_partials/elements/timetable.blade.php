<div class="timetable">

	{{ Form::open(['route' => 'activities.timetable', 'method' => 'GET']) }}
		<div>
			Show classes week beginning:
			{{ Form::text('date', Input::old('date'), ['class' => 'datepicker']) }}
			<button type="submit">Go</button>
		</div>
	{{ Form::close() }}

	<h3>Your Timetable</h3>

	<nav class="nav-days">
		<ul>
			@foreach( $activities as $day => $collection )
				<li><a href="#" data-target="{{ $day }}">{{ $day }}</a></li>
			@endforeach
		</ul>
	</nav>

	@foreach( $activities as $day => $collection )

		<div data-day="{{ $day }}" class="day">
			
			@if( !$collection->isEmpty() )

				@foreach( $collection as $activity )

					@include('_partials.instructor.activity', ['activity' => $activity])

				@endforeach

			@else

				<div class="alert alert-info">No activities on this day</div>

			@endif

		</div>

	@endforeach

</div>

<script>

	jQuery(document).ready(function($) {

		$('.datepicker').datetimepicker({
			timepicker: false,
			format:'Y-m-d',
			minDate: 0,
			closeOnDateSelect: true
		});

	});

</script>

{{ HTML::script('js/timetable.js') }}