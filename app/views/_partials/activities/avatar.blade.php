@if( $activity->avatar )
	<img src="/active/public/{{ $activity->avatar }}" alt="{{ $activity->name }}" />
@else
	<img src="http://placehold.it/200x200" alt="{{ $activity->name }}" />
@endif