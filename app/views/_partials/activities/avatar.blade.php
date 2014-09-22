@if( $activity->avatar )
	<a href="{{ $activity->getLink() }}">
		<img src="/active/public/{{ $activity->avatar }}" alt="{{ $activity->name }}" />
	</a>
@else
	<img src="http://placehold.it/200x200" alt="{{ $activity->name }}" />
@endif