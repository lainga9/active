@if( !$activity->coverApplicants->isEmpty() )

	<hr />

	@if( $activity->coverInstructor )

		<p>You have selected {{ $activity->coverInstructor->getName() }} to cover this activity</p>

	@else

		<h4>Cover Applicants</h4>
		@foreach( $activity->coverApplicants as $applicant )
			<p><a href="{{ $applicant->getLink() }}">{{ $applicant->getName() }}</a></p>
			{{ Form::open(['route' => ['activity.acceptCover', $activity->id]]) }}
				<input type="hidden" name="cover_applicant_id" value="{{ $applicant->id }}" />
				<button type="submit" class="btn btn-xs btn-success">Accept</button>
			{{ Form::close() }}
		@endforeach

	@endif

@endif