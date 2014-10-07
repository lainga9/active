@section('title', $activity->name)

@section('content')

	@if( $activity->isFull() )
		<div class="alert alert-info">
			This class is currently fully booked!
		</div>
	@endif

	@if( $activity->isCancelled() )
		<div class="alert alert-danger">
			This class has been cancelled!
		</div>
	@endif

	<div class="row">

		<div class="col-sm-3">
			<!-- Avatar -->
			@include('_partials.activities.avatar', compact('activity'))

			<!-- Name -->
			<h3 class="text-success">{{ $activity->getName() }}</h3>

			<!-- Average Rating of Instructor -->
			@include('_partials.elements.averageRating', ['instructor' => $instructor])

			<!-- Difficult Level -->
			<p>{{ $activity->getLevel() }}</p>

			<!-- Places Left -->
			<p>Places left: {{ $activity->getPlacesLeft() }}</p>

			<!-- Price -->
			<p>Price: {{ $activity->getPrice() }}</p>

			<!-- Edit activity if yours -->
			@if( $activity->isOwn() )
				<a href="{{ URL::route('activities.edit', $activity->id) }}" class="btn btn-info">Edit Activity</a>

				<!-- Apply for cover -->
				@if( !$activity->needsCover() )
					
					@include('_partials.elements.findCover', compact('activity'))

				@endif

				@include('_partials.activities.coverApplicants', compact('activity'))

			@else

				<!-- Add to your timetable -->
				@if( $instructor->isOrganisation() && Auth::user()->isInstructor() && !$activity->taughtBy )

					{{ Form::open(['route' => ['activity.addToTimetable', $activity->id]]) }}
						<button type="submit" class="btn btn-info">Add to my timetable</button>
					{{ Form::close() }}

				@endif

				<!-- Book Button -->
				@include('_partials.elements.bookActivity', compact('activity'))
			@endif
		</div>

		<div class="col-sm-6">
			<!-- Map -->
			<iframe width="100%" height="250" frameborder="0" scrolling="no"  marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;q=<?= $activity->makeAddressURL() ?>&amp;output=embed"></iframe>

			<!-- Address -->
			<p><i class="fa fa-map-marker"></i> Address: {{ $activity->getAddress() }}</p>

			<!-- Date and Time -->
			<p>Date: {{ $activity->getDate() }} Time: {{ $activity->getTime() }}</p>

			<!-- Type -->
			<p>Activity Type: {{ $activity->getTypes() }}</p>

			<!-- Description -->
			<p>{{ $activity->getDescription() }}</p>
			<p></p>
		</div>

		<div class="col-sm-3">

			<!-- Instructor Bio -->
			<div class="row">
				<div class="col-sm-4">

					<!-- Avatar -->
					@include('_partials.users.avatar', ['user' => $instructor])
				</div>
				<div class="col-sm-8">

					<!-- Name and Address -->
					<p>Activity Host</p>
					<h4><a href="{{ URL::route('users.show', $instructor->id) }}">{{ $instructor->getName() }}</a></h4>
					{{ $instructor->getAddress() }}
				</div>
			</div>

			<!-- Website -->
			@if( $website = $instructor->getWebsite() )
				<a href="{{ $website }}">{{ $website }}</a>
			@endif
			<hr />

			<!-- Phone -->
			@if( $phone = $instructor->getPhone() )
				<p>Tel: {{ $phone }}</p>
			@endif

			<!-- Mobile -->
			@if( $mobile = $instructor->getMobile() )
				<p>Mob: {{ $mobile }}</p>
			@endif

			@if( !$activity->isOwn() )
			
				<!-- Send Message -->
				@include('_partials.elements.sendMessage', ['user' => $instructor])

				<!-- Follow Button -->
				@include('_partials.elements.followButton', ['user' => $instructor])

				<!-- Leave Feedback -->
				@include('_partials.elements.leaveFeedback', ['instructor' => $instructor])

			@endif

		</div>
	</div>
	
@stop