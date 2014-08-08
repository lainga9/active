@section('title', $activity->name)

@section('content')

	@if( $activity->isFull() )
		<div class="alert alert-info">
			This class is currently fully booked!
		</div>
	@endif

	<div class="row">
		<div class="col-md-3">

			<iframe width="100%" height="250" frameborder="0" scrolling="no"  marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;q=<?= $activity->makeAddressURL() ?>&amp;output=embed"></iframe>

			<h5>Address</h5>
			{{ $activity->street_address }} <br />
			{{ $activity->town }} <br />
			{{ $activity->postcode }}

			<hr />

			<h5>Telephone</h5>
			{{ $activity->instructor->userable->phone }}

			<hr >

			<h5>Mobile</h5>
			{{ $activity->instructor->userable->mobile }}

			<hr />

			@include('_partials.elements.sendMessage', ['instructor' => $activity->instructor])

		</div>
		<div class="col-md-9">

			<div class="row">
				<div class="col-md-3">
					<img src="http://placehold.it/200x200" alt="{{ $activity->instructor->first_name }}" />
					<h5>Host:</h5>
					<a href="{{ URL::route('users.show', $activity->instructor->id) }}" class="text-success">{{ $activity->instructor->first_name }} {{ $activity->instructor->last_name }}</a>
					<h5>Host Rating</h5>
					@if( $feedback = $activity->instructor->userable->getAverageFeedback() )
						<p>{{ $feedback }}</p>
					@else
						<p>No Reviews</p>
					@endif
					<hr />
					@include('_partials.elements.leaveFeedback', ['instructor' => $activity->instructor])
				</div>
				<div class="col-md-9">
					<h3>{{ $activity->name }}</h3>
					<hr />
					<h5>Class Type</h5>
					@if( $classTypes = $activity->classTypes )
						@foreach( $classTypes as $classType )
							{{ $classType->name }}
						@endforeach
					@endif

					<h5>Suitable for</h5>

					<h5>Places Available</h5>
					{{ $activity->places }}

					<h5>Information</h5>
					{{ $activity->description }}
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							{{ $activity->time_from }} - {{ $activity->time_until }}
						</div>
						<div class="col-md-4">
							{{ date('l', strtotime($activity->date)) }} {{ $activity->date }}
						</div>
						<div class="col-md-4">
							&pound;{{ $activity->cost }}
						</div>
					</div>
				</div>
				<div class="col-md-4">
					@include('_partials.elements.bookActivity', compact($activity))
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					@if( $activity->isFavourite() )
						@include('_partials.elements.removeFavourite')
					@else
						@include('_partials.elements.addFavourite')
					@endif
				</div>
				<div class="col-md-4">
					
				</div>
			</div>

		</div>
	</div>
	
@stop