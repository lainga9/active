@if( !$user->socialStream()->isEmpty() )

	@foreach( $user->socialStream() as $action )

		@include('_partials.elements.action', compact('action'))
		
	@endforeach

@endif